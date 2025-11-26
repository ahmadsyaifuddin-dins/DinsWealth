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
        $this->model = env('OPENAI_MODEL', 'llama-3.3-70b-versatile');
    }

    public function getInsight()
    {
        $dataContext = $this->prepareFinancialData();
        return $this->askAi($dataContext);
    }

    /**
     * Hitung Data Mentah
     */
    private function prepareFinancialData()
    {
        $now = Carbon::now();
        $lastMonth = $now->copy()->subMonth();

        // 1. Saldo Real
        $totalPemasukanAll = Tabungan::where('jenis', '1')->sum('nominal');
        $totalPengeluaranAll = Tabungan::where('jenis', '2')->sum('nominal');
        $saldoReal = $totalPemasukanAll - $totalPengeluaranAll;

        // 2. Data Bulan Ini
        $pemasukanBulanIni = Tabungan::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->where('jenis', '1')->sum('nominal');

        $pengeluaranBulanIni = Tabungan::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->where('jenis', '2')->sum('nominal');

        // 3. Data HARI INI (Fitur Baru)
        $pengeluaranHariIni = Tabungan::whereDate('created_at', $now->today())
            ->where('jenis', '2')
            ->sum('nominal');
            
        // Ambil detail transaksi hari ini (max 3 biji buat contoh)
        $transaksiHariIni = Tabungan::whereDate('created_at', $now->today())
            ->where('jenis', '2')
            ->take(3)
            ->pluck('keterangan')
            ->implode(', ');

        // 4. Data Bulan Lalu
        $pengeluaranBulanLalu = Tabungan::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->where('jenis', '2')->sum('nominal');

        // 5. Kategori Terboros
        $topCategory = Tabungan::select('nama', DB::raw('sum(nominal) as total'))
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->where('jenis', '2')
            ->groupBy('nama')
            ->orderByDesc('total')
            ->first();

        $namaKategoriTop = '-';
        if ($topCategory) {
            $kategoriDb = KategoriNamaTabungan::find($topCategory->nama);
            $namaKategoriTop = $kategoriDb ? $kategoriDb->nama : 'Lainnya';
        }

        // Persentase
        $selisih = $pengeluaranBulanIni - $pengeluaranBulanLalu;
        if ($pengeluaranBulanLalu > 0) {
            $persen = round(($selisih / $pengeluaranBulanLalu) * 100);
        } else {
            $persen = $pengeluaranBulanIni > 0 ? 100 : 0;
        }
        
        $statusNaikTurun = $selisih > 0 ? "NAIK (Lebih boros)" : "TURUN (Lebih hemat)";

        return [
            'bulan_ini' => $now->translatedFormat('F Y'),
            'saldo_real' => $saldoReal,
            'total_pemasukan' => $pemasukanBulanIni,
            'total_pengeluaran' => $pengeluaranBulanIni,
            'pengeluaran_hari_ini' => $pengeluaranHariIni,
            'transaksi_hari_ini' => $transaksiHariIni,
            'status_pengeluaran' => $statusNaikTurun,
            'persentase_perubahan' => abs($persen) . '%',
            'kategori_boros' => $namaKategoriTop,
        ];
    }

    /**
     * Kirim Prompt ke AI
     */
    private function askAi($data)
    {
        $baseUrl = env('OPENAI_BASE_URL', 'https://api.groq.com/openai/v1/chat/completions');

        $prompt = "
        Berperanlah sebagai pacar perempuannya Ahmad Syaifuddin yang sangat perhatian, sayang, tapi agak cerewet (possesive cute) soal keuangan.
        
        DATA KEUANGAN Ahmad Syaifuddin:
        1. Pengeluaran HARI INI: Rp " . number_format($data['pengeluaran_hari_ini']) . "
           (Detail jajan hari ini: " . ($data['transaksi_hari_ini'] ?: 'Gak ada jajan') . ")
           -> INSTRUKSI: Komentari ini DULU. Kalau 0 puji dia. Kalau boros, omelin manja.
           
        2. Saldo Total Saat Ini: Rp " . number_format($data['saldo_real']) . "
        
        3. Pengeluaran Bulan Ini ({$data['bulan_ini']}): Rp " . number_format($data['total_pengeluaran']) . "
           (Tren: {$data['status_pengeluaran']} {$data['persentase_perubahan']} dibanding bulan lalu).

        Tugasmu:
        Berikan komentar singkat (3-4 kalimat) layaknya chat WA pacar:
        - Panggil 'Sayang', 'Beb', atau 'Ayang'.
        - WAJIB notice pengeluaran HARI INI.
        - Gunakan emoji lucu/romantis 😘 😤 😭.
        - Tutup dengan motivasi nabung/halalin aku.
        ";

        try {
            $response = Http::timeout(30)
                ->withToken($this->apiKey)
                ->post($baseUrl, [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => 'Kamu adalah pacar Ahmad Syaifuddin yang perhatian.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.8,
                'max_tokens' => 350,
            ]);

            if ($response->successful()) {
                return $response->json()['choices'][0]['message']['content'];
            } else {
                return "AI Error: Gagal terhubung ke hati ayang (API Error).";
            }
        } catch (\Exception $e) {
            return "System Error: " . $e->getMessage();
        }
    }
}