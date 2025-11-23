<?php

namespace App\Helpers;
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
        // Default ke Llama 3.3 jika .env tidak diatur
        $this->model = env('OPENAI_MODEL', 'llama-3.3-70b-versatile');
    }

    /**
     * Fungsi Utama: Ambil Insight
     */
    public function getInsight()
    {
        // Siapkan Data Mentah dari Laravel
        $dataContext = $this->prepareFinancialData();

        // Kirim ke AI
        return $this->askAi($dataContext);
    }

    /**
     * Hitung Data Mentah (Laravel Side)
     */
    private function prepareFinancialData()
    {
        $now = Carbon::now();
        $lastMonth = $now->copy()->subMonth();

        // ID Jenis: 1 = Pemasukan, 2 = Pengeluaran
        
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

        // C. Cari Kategori Pengeluaran Terbesar
        $topCategory = Tabungan::select('nama', DB::raw('sum(nominal) as total'))
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->where('jenis', '2') // Pengeluaran saja
            ->groupBy('nama')
            ->orderByDesc('total')
            ->first();

        $namaKategoriTop = '-';
        if ($topCategory) {
            $kategoriDb = KategoriNamaTabungan::find($topCategory->nama);
            $namaKategoriTop = $kategoriDb ? $kategoriDb->nama : 'Lainnya';
        }

        // Hitung persentase kenaikan/penurunan
        $selisih = $pengeluaranBulanIni - $pengeluaranBulanLalu;
        // Hindari division by zero
        if ($pengeluaranBulanLalu > 0) {
            $persen = round(($selisih / $pengeluaranBulanLalu) * 100);
        } else {
            $persen = $pengeluaranBulanIni > 0 ? 100 : 0;
        }
        
        $statusNaikTurun = $selisih > 0 ? "NAIK (Lebih boros)" : "TURUN (Lebih hemat)";

        return [
            'bulan_ini' => $now->translatedFormat('F Y'),
            'total_pemasukan' => $pemasukanBulanIni,
            'total_pengeluaran' => $pengeluaranBulanIni,
            'pengeluaran_bulan_lalu' => $pengeluaranBulanLalu,
            'status_pengeluaran' => $statusNaikTurun,
            'persentase_perubahan' => abs($persen) . '%',
            'kategori_boros' => $namaKategoriTop,
            'saldo_bulan_ini' => $pemasukanBulanIni - $pengeluaranBulanIni
        ];
    }

    /**
     * Kirim Prompt ke AI (Groq/OpenAI)
     * PROMPT ENGINEERED: GIRLFRIEND MODE ❤️
     */
    private function askAi($data)
    {
        $baseUrl = env('OPENAI_BASE_URL', 'https://api.groq.com/openai/v1/chat/completions');

        // --- PROMPT: MODE PACAR PERHATIAN ---
        $prompt = "
        Berperanlah sebagai pacar perempuannya Dins yang sangat perhatian, sayang, tapi agak cerewet kalau soal keuangan.
        Kamu selalu ingin Dins sukses dan punya tabungan masa depan buat kalian berdua.
        Panggilanmu ke dia: 'Sayang', 'Beb', atau 'Ayang'.
        
        Data Keuangan Dins Bulan Ini ({$data['bulan_ini']}):
        - Pemasukan: Rp " . number_format($data['total_pemasukan']) . "
        - Pengeluaran: Rp " . number_format($data['total_pengeluaran']) . "
        - Saldo (Cashflow): Rp " . number_format($data['saldo_bulan_ini']) . "
        - Tren Pengeluaran vs Bulan Lalu: {$data['status_pengeluaran']} sebesar {$data['persentase_perubahan']}
        - Kategori Paling Banyak Jajan: {$data['kategori_boros']}

        Tugasmu:
        Berikan komentar singkat (maksimal 3-4 kalimat) selayaknya chat WA dari pacar:
        1. Gunakan bahasa aku-kamu yang hangat, pakai emoji love/kiss di akhir. 😘
        2. Kalau pengeluaran NAIK/BOROS: Marah manja/ngambek lucu. Ingatkan soal nabung buat halalin aku / masa depan. 💍
        3. Kalau pengeluaran HEMAT: Puji dia setinggi langit, bilang bangga punya cowok pinter atur duit. ❤️
        4. Kalau saldo TIPIS: Kasih semangat, tawarkan dukungan emosional (misal: 'Gapapa sayang, nanti kita cari cuan bareng ya').
        
        Format Jawaban (Langsung paragraf, natural seperti chat):
        [Panggilan sayang + Reaksi emosional] [Komentar soal data] [Saran/Dukungan manis].
        ";

        try {
            $response = Http::timeout(30)
                ->withToken($this->apiKey)
                ->post($baseUrl, [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => 'Kamu adalah pacar Dins yang sangat perhatian, manja, dan peduli masa depan.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.8, // Agak kreatif biar bawelnya natural
                'max_tokens' => 350,
            ]);

            if ($response->successful()) {
                return $response->json()['choices'][0]['message']['content'];
            } else {
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