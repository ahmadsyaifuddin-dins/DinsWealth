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

        // ... (Logika data untuk kartu ringkasan dan grafik tetap sama) ...
        $totalPemasukan = Tabungan::whereHas('kategoriJenis', fn($q) => $q->where('jenis', 'Pemasukan'))->sum('nominal');
        $totalPengeluaran = Tabungan::whereHas('kategoriJenis', fn($q) => $q->where('jenis', 'Pengeluaran'))->sum('nominal');
        $saldoSaatIni = $totalPemasukan - $totalPengeluaran;
        $pemasukanBulanIni = Tabungan::whereHas('kategoriJenis', fn($q) => $q->where('jenis', 'Pemasukan'))
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('nominal');
        $transaksiTerakhir = Tabungan::with(['kategoriNama', 'kategoriJenis'])->latest()->take(5)->get();
        $pengeluaran7Hari = Tabungan::whereHas('kategoriJenis', fn($q) => $q->where('jenis', 'Pengeluaran'))
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->get()
            ->groupBy(fn($date) => Carbon::parse($date->created_at)->format('d M'))
            ->map(fn($group) => $group->sum('nominal'));
        $chartData = [
            'labels' => $pengeluaran7Hari->keys(),
            'data' => $pengeluaran7Hari->values(),
        ];
        
        // ===============================================
        // BAGIAN BARU: AMBIL DATA UNTUK MODAL
        // ===============================================
        $namaKategori = KategoriNamaTabungan::all();
        $jenisKategori = KategoriJenisTabungan::all();
        // ===============================================

        // Kirim semua data ke view 'admin.dashboard'
        // Ganti view('dashboard') menjadi view('admin.dashboard') sesuai rute kamu
        return view('admin.dashboard', compact(
            'saldoSaatIni',
            'pemasukanBulanIni',
            'transaksiTerakhir',
            'chartData',
            'namaKategori',      // <-- Tambahkan ini
            'jenisKategori'      // <-- Tambahkan ini
        ));
    }
}