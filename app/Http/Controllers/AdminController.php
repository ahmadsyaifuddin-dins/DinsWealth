<?php
namespace App\Http\Controllers;
use App\Models\Tabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
// TAMBAHKAN USE STATEMENT INI
use App\Models\KategoriNamaTabungan;
use App\Models\KategoriJenisTabungan;

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard utama untuk admin.
     */
    public function index()
    {
        if (Auth::user()->role !== 'dins') {
            abort(403, 'Akses Ditolak');
        }
        
        // ... (Logika data untuk kartu ringkasan tetap sama) ...
        $totalPemasukan = Tabungan::whereHas('kategoriJenis', fn($q) => $q->where('jenis', 'Pemasukan'))->sum('nominal');
        $totalPengeluaran = Tabungan::whereHas('kategoriJenis', fn($q) => $q->where('jenis', 'Pengeluaran'))->sum('nominal');
        $saldoSaatIni = $totalPemasukan - $totalPengeluaran;
        
        $pemasukanBulanIni = Tabungan::whereHas('kategoriJenis', fn($q) => $q->where('jenis', 'Pemasukan'))
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('nominal');
            
        $pengeluaranBulanIni = Tabungan::whereHas('kategoriJenis', fn($q) => $q->where('jenis', 'Pengeluaran'))
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('nominal');
            
        $transaksiTerakhir = Tabungan::with(['kategoriNama', 'kategoriJenis'])->latest()->take(5)->get();
        
        // ===============================================
        // CHART DATA: PENGELUARAN 7 HARI
        // ===============================================
        $pengeluaran7Hari = Tabungan::whereHas('kategoriJenis', fn($q) => $q->where('jenis', 'Pengeluaran'))
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('j'); // Tanggal saja
            })
            ->map(fn($group) => $group->sum('nominal'));
        
        // Buat array lengkap untuk 7 hari terakhir
        $weeklyLabels = [];
        $weeklyData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = now()->subDays($i);
            $day = $tanggal->format('j');
            
            // Format: "1 Agt", "2 Agt"
            $weeklyLabels[] = $tanggal->format('j') . ' ' . $tanggal->locale('id')->format('M');
            $weeklyData[] = $pengeluaran7Hari->get($day, 0);
        }
        
        $weeklyChartData = [
            'labels' => $weeklyLabels,
            'data' => $weeklyData,
            'periode' => '7 Hari Terakhir',
            'total' => array_sum($weeklyData)
        ];
        
        // ===============================================
        // CHART DATA: PENGELUARAN 1 BULAN PENUH
        // ===============================================
        $bulanIni = now()->month;
        $tahunIni = now()->year;
        $jumlahHariBulanIni = now()->daysInMonth;
        
        // Ambil data pengeluaran per tanggal dalam bulan ini
        $pengeluaranBulanan = Tabungan::whereHas('kategoriJenis', fn($q) => $q->where('jenis', 'Pengeluaran'))
            ->whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('j'); // j = tanggal tanpa leading zero (1-31)
            })
            ->map(fn($group) => $group->sum('nominal'));
        
        // Buat array lengkap untuk semua tanggal dalam bulan
        $monthlyLabels = [];
        $monthlyData = [];
        
        for ($i = 1; $i <= $jumlahHariBulanIni; $i++) {
            $tanggal = Carbon::create($tahunIni, $bulanIni, $i);
            
            // Format label: "1", "2", "3" (simple untuk monthly)
            $monthlyLabels[] = $tanggal->format('j');
            
            // Ambil nominal pengeluaran, jika tidak ada = 0
            $monthlyData[] = $pengeluaranBulanan->get($i, 0);
        }
        
        $monthlyChartData = [
            'labels' => $monthlyLabels,
            'data' => $monthlyData,
            'bulan' => now()->locale('id')->isoFormat('MMMM Y'), // "Agustus 2025"
            'totalHari' => $jumlahHariBulanIni,
            'total' => array_sum($monthlyData)
        ];
        
        // ===============================================
        // BAGIAN: AMBIL DATA UNTUK MODAL
        // ===============================================
        $namaKategori = KategoriNamaTabungan::all();
        $jenisKategori = KategoriJenisTabungan::all();
        
        // ===============================================
        // Kirim semua data ke view 'admin.dashboard'
        // ===============================================
        return view('admin.dashboard', compact(
            'saldoSaatIni',
            'pemasukanBulanIni',
            'pengeluaranBulanIni',
            'transaksiTerakhir',
            'monthlyChartData',      // Chart 1 bulan penuh
            'weeklyChartData',       // Chart 7 hari
            'namaKategori',     
            'jenisKategori'     
        ));
    }
}