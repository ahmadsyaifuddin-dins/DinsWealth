<?php

namespace App\Services;

use App\Models\Tabungan;
use App\Models\KategoriNamaTabungan;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AiFinancialInsight
{
    protected $apiKey;
    protected $model;

    public function __construct()
    {
        $this->apiKey = env('OPENAI_API_KEY');
        $this->model = env('OPENAI_MODEL', 'gpt-3.5-turbo');
    }

    /**
     * 1. Cek apakah API Key Valid/Aktif sebelum melakukan heavy request
     */
    public function checkConnection()
    {
        try {
            $response = Http::withToken($this->apiKey)
                ->get('https://api.openai.com/v1/models');

            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 2. Fungsi Utama: Ambil Insight
     */
    public function getInsight()
    {
        // Siapkan Data Mentah dari Laravel
        $dataContext = $this->prepareFinancialData();

        // Kirim ke AI
        return $this->askAi($dataContext);
    }

    /**
     * 3. Hitung Data Mentah (Laravel Side)
     * Agar hemat token dan data privasi aman, kita hitung total di sini.
     */
    private function prepareFinancialData()
    {
        $now = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        // ID Jenis: 1 = Pemasukan, 2 = Pengeluaran (Sesuai SQL Dump)
        
        // A. Hitung Bulan Ini
        $pemasukanBulanIni = Tabungan::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->where('jenis', '1')
            ->sum('nominal');

        $pengeluaranBulanIni = Tabungan::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->where('jenis', '2')
            ->sum('nominal');

        // B. Hitung Bulan Lalu (untuk perbandingan)
        $pengeluaranBulanLalu = Tabungan::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->where('jenis', '2')
            ->sum('nominal');

        // C. Cari Kategori Pengeluaran Terbesar Bulan Ini
        // Note: Di tabel 'tabungans', kolom 'nama' menyimpan ID kategori (misal: '3', '2') tapi tipe datanya string.
        // Kita perlu join atau grouping.
        $topCategory = Tabungan::select('nama', DB::raw('sum(nominal) as total'))
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->where('jenis', '2') // Pengeluaran saja
            ->groupBy('nama')
            ->orderByDesc('total')
            ->first();

        $namaKategoriTop = '-';
        if ($topCategory) {
            // Ambil nama asli dari tabel kategori_nama_tabungans
            $kategoriDb = KategoriNamaTabungan::find($topCategory->nama);
            $namaKategoriTop = $kategoriDb ? $kategoriDb->nama : 'Lainnya';
        }

        // Hitung persentase kenaikan/penurunan
        $selisih = $pengeluaranBulanIni - $pengeluaranBulanLalu;
        $persen = $pengeluaranBulanLalu > 0 ? round(($selisih / $pengeluaranBulanLalu) * 100) : 100;
        $statusNaikTurun = $selisih > 0 ? "NAIK" : "TURUN";

        // Return Data Array yang bersih untuk dikirim ke AI
        return [
            'bulan_ini' => $now->translatedFormat('F Y'),
            'total_pemasukan' => $pemasukanBulanIni,
            'total_pengeluaran' => $pengeluaranBulanIni,
            'pengeluaran_bulan_lalu' => $pengeluaranBulanLalu,
            'status_pengeluaran' => $statusNaikTurun,
            'persentase_perubahan' => abs($persen) . '%',
            'kategori_boros' => $namaKategoriTop,
        ];
    }

    /**
     * 4. Kirim Prompt ke AI
     */
    private function askAi($data)
    {
        // 1. Ambil Config (Sekarang mengarah ke Groq)
        $modelToUse = env('OPENAI_MODEL', 'llama3-8b-8192'); 
        
        // Default fallback URL jika di .env lupa diisi
        $baseUrl = env('OPENAI_BASE_URL', 'https://api.groq.com/openai/v1/chat/completions');

        $prompt = "
        Bertindaklah sebagai penasihat keuangan pribadi yang santai namun bijak untuk seorang mahasiswa informatika.
        Berikut adalah data keuangan saya bulan ini:
        - Bulan: {$data['bulan_ini']}
        - Pemasukan: Rp " . number_format($data['total_pemasukan']) . "
        - Pengeluaran: Rp " . number_format($data['total_pengeluaran']) . "
        - Perbandingan Pengeluaran vs Bulan Lalu: {$data['status_pengeluaran']} sebesar {$data['persentase_perubahan']}
        - Kategori Paling Boros: {$data['kategori_boros']}

        Tugasmu:
        Berikan ringkasan singkat (maksimal 3-4 kalimat).
        1. Highlight kondisi keuangan saya (apakah bahaya atau aman).
        2. Berikan saran spesifik berdasarkan kategori boros tersebut.
        3. Gunakan bahasa Indonesia yang luwes, memotivasi, dan tidak kaku. Panggil saya 'Bro' atau 'Dins'.
        ";

        try {
            // 2. Request ke URL Groq
            $response = Http::timeout(30)
                ->withToken($this->apiKey) // Ini akan pakai key 'gsk_...' dari .env
                ->post($baseUrl, [ // Menggunakan URL Groq
                    'model' => $modelToUse,
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a helpful financial assistant.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 300,
            ]);

            if ($response->successful()) {
                return $response->json()['choices'][0]['message']['content'];
            } else {
                // Debug Error
                $errorBody = $response->json();
                $pesanError = isset($errorBody['error']['message']) 
                    ? $errorBody['error']['message'] 
                    : 'Unknown Error';
                return "AI Error [{$response->status()}]: " . $pesanError;
            }
        } catch (\Exception $e) {
            return "System Error: " . $e->getMessage();
        }
    }
}