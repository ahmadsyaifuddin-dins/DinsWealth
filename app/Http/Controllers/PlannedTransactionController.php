<?php

namespace App\Http\Controllers;

use App\Models\KategoriJenisTabungan;
use App\Models\KategoriNamaTabungan;
use App\Models\PlannedTransaction;
use App\Models\Tabungan;
use Illuminate\Http\Request;

class PlannedTransactionController extends Controller
{
    public function index()
    {
        $plannedTransactions = PlannedTransaction::with(['kategoriNama', 'kategoriJenis'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        $namaKategori = KategoriNamaTabungan::all();
        $jenisKategori = KategoriJenisTabungan::all();

        return view('planned-transactions.index', compact('plannedTransactions', 'namaKategori', 'jenisKategori'));
    }

    public function create()
    {
        $namaKategori = KategoriNamaTabungan::all();
        $jenisKategori = KategoriJenisTabungan::all();
        return view('planned-transactions.create', compact('namaKategori', 'jenisKategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|exists:kategori_nama_tabungans,id',
            'jenis' => 'required|exists:kategori_jenis_tabungans,id',
            'nominal' => 'required|numeric|min:0', // Validasi nilai nominal yang sudah bersih
            'keterangan' => 'required|string|max:255',
            'jatuh_tempo' => 'required|date',
        ]);

        $validated['user_id'] = auth()->id();
        PlannedTransaction::create($validated);

        return redirect()->route('planned-transactions.index')->with('success', 'Rencana transaksi berhasil ditambahkan.');
    }


    public function edit(PlannedTransaction $plannedTransaction)
    {
        // Cek apakah user adalah pemilik data
        if ($plannedTransaction->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak. Anda hanya bisa mengedit data Anda sendiri.');
        }

        $namaKategori = KategoriNamaTabungan::all();
        $jenisKategori = KategoriJenisTabungan::all();
        return view('planned-transactions.edit', compact('plannedTransaction', 'namaKategori', 'jenisKategori'));
    }

    public function update(Request $request, PlannedTransaction $plannedTransaction)
    {
        // Cek apakah user adalah pemilik data
        if ($plannedTransaction->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak. Anda hanya bisa mengupdate data Anda sendiri.');
        }

        $validated = $request->validate([
            'nama' => 'required|exists:kategori_nama_tabungans,id',
            'jenis' => 'required|exists:kategori_jenis_tabungans,id',
            'nominal' => 'required|numeric|min:0',
            'keterangan' => 'required|string|max:255',
            'jatuh_tempo' => 'required|date',
            'tanggal_peristiwa' => 'nullable|date',
        ]);

        $plannedTransaction->update($validated);

        return redirect()->route('planned-transactions.index')->with('success', 'Rencana transaksi berhasil diupdate.');
    }

    public function destroy(PlannedTransaction $plannedTransaction)
    {
        // Cek apakah user adalah pemilik data
        if ($plannedTransaction->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak. Anda hanya bisa menghapus data Anda sendiri.');
        }

        $plannedTransaction->delete();
        return redirect()->route('planned-transactions.index')->with('success', 'Rencana transaksi berhasil dihapus.');
    }

    public function complete(Request $request, PlannedTransaction $plannedTransaction)
    {
        // Cek apakah user adalah pemilik data
        if ($plannedTransaction->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak. Anda hanya bisa menyelesaikan rencana Anda sendiri.');
        }

        $request->validate(['tanggal_peristiwa' => 'required|date']);

        // 1. Buat transaksi baru di tabel 'tabungans'
        Tabungan::create([
            'nama' => $plannedTransaction->nama,
            'jenis' => $plannedTransaction->jenis,
            'nominal' => $plannedTransaction->nominal,
            'keterangan' => $plannedTransaction->keterangan . " (Realisasi dari rencana)",
            'user_id' => auth()->id(),
            'created_at' => $request->tanggal_peristiwa,
            'updated_at' => $request->tanggal_peristiwa,
        ]);

        // 2. Update status rencana menjadi 'done'
        $plannedTransaction->update([
            'status' => 'done',
            'tanggal_peristiwa' => $request->tanggal_peristiwa,
        ]);

        return redirect()->route('planned-transactions.index')->with('success', 'Rencana transaksi berhasil direalisasikan!');
    }
}
