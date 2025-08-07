<?php
namespace App\Http\Controllers;

use App\Models\Tabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\KategoriNamaTabungan;
use App\Models\KategoriJenisTabungan;
use App\Helpers\DashboardGreetingHelper;

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
        
        // Data ringkasan keuangan
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
        
        // Chart data: 7 hari terakhir
        $weeklyChartData = $this->getWeeklyChartData();
        
        // Chart data: 1 bulan penuh
        $monthlyChartData = $this->getMonthlyChartData();
        
        // Generate greeting menggunakan Helper
        $pengeluaranHariIni = Tabungan::whereHas('kategoriJenis', fn($q) => $q->where('jenis', 'Pengeluaran'))
            ->whereDate('created_at', now()->toDateString())
            ->sum('nominal');
        
        $rataRataPengeluaranHarian = Tabungan::whereHas('kategoriJenis', fn($q) => $q->where('jenis', 'Pengeluaran'))
            ->where('created_at', '>=', now()->subDays(30))
            ->sum('nominal') / 30;
        
        $greeting = DashboardGreetingHelper::generateDailyGreeting(
            $pengeluaranHariIni,
            $rataRataPengeluaranHarian,
            $saldoSaatIni
        );
        
        // Data untuk modal
        $namaKategori = KategoriNamaTabungan::all();
        $jenisKategori = KategoriJenisTabungan::all();
        
        return view('admin.dashboard', compact(
            'saldoSaatIni',
            'pemasukanBulanIni',
            'pengeluaranBulanIni',
            'transaksiTerakhir',
            'monthlyChartData',
            'weeklyChartData',
            'greeting',
            'pengeluaranHariIni',
            'namaKategori',
            'jenisKategori'
        ));
    }
    
    /**
     * Get chart data untuk 7 hari terakhir
     */
    private function getWeeklyChartData()
    {
        $pengeluaran7Hari = Tabungan::whereHas('kategoriJenis', fn($q) => $q->where('jenis', 'Pengeluaran'))
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('j');
            })
            ->map(fn($group) => $group->sum('nominal'));
        
        $weeklyLabels = [];
        $weeklyData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = now()->subDays($i);
            $day = $tanggal->format('j');
            
            $weeklyLabels[] = $tanggal->format('j') . ' ' . $tanggal->locale('id')->format('M');
            $weeklyData[] = $pengeluaran7Hari->get($day, 0);
        }
        
        return [
            'labels' => $weeklyLabels,
            'data' => $weeklyData,
            'periode' => '7 Hari Terakhir',
            'total' => array_sum($weeklyData)
        ];
    }
    
    /**
     * Get chart data untuk 1 bulan penuh
     */
    private function getMonthlyChartData()
    {
        $bulanIni = now()->month;
        $tahunIni = now()->year;
        $jumlahHariBulanIni = now()->daysInMonth;
        
        $pengeluaranBulanan = Tabungan::whereHas('kategoriJenis', fn($q) => $q->where('jenis', 'Pengeluaran'))
            ->whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('j');
            })
            ->map(fn($group) => $group->sum('nominal'));
        
        $monthlyLabels = [];
        $monthlyData = [];
        
        for ($i = 1; $i <= $jumlahHariBulanIni; $i++) {
            $tanggal = Carbon::create($tahunIni, $bulanIni, $i);
            $monthlyLabels[] = $tanggal->format('j');
            $monthlyData[] = $pengeluaranBulanan->get($i, 0);
        }
        
        return [
            'labels' => $monthlyLabels,
            'data' => $monthlyData,
            'bulan' => now()->locale('id')->isoFormat('MMMM Y'),
            'totalHari' => $jumlahHariBulanIni,
            'total' => array_sum($monthlyData)
        ];
    }
}