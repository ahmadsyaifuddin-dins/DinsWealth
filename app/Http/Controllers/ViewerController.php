<?php

namespace App\Http\Controllers;

use App\Models\Tabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ViewerController extends Controller
{
    public function index()
    {
        // 1. Data untuk Kartu Ringkasan
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

        // 2. Data untuk Pie Chart
        $chartData = [
            'pemasukan' => $pemasukanBulanIni,
            'pengeluaran' => $pengeluaranBulanIni,
        ];

        // 3. Data untuk Daftar Transaksi Terakhir
        $transaksiTerakhir = Tabungan::with(['kategoriNama', 'kategoriJenis'])->latest()->take(5)->get();

        return view('viewer.dashboard', compact(
            'saldoSaatIni',
            'pemasukanBulanIni',
            'pengeluaranBulanIni',
            'transaksiTerakhir',
            'chartData'
        ));
    }
}