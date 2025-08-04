<?php

namespace App\Http\Controllers;

use App\Models\KategoriJenisTabungan;
use App\Models\KategoriNamaTabungan;
use App\Models\PlannedTransaction;
use App\Models\Tabungan;
use Illuminate\Http\Request;

class PlannedTransactionController extends Controller
{
    public function index(Request $request)
    {
        // Validate filter inputs
        $request->validate([
            'search' => 'nullable|string|max:255',
            'nama' => 'nullable|exists:kategori_nama_tabungans,id',
            'jenis' => 'nullable|exists:kategori_jenis_tabungans,id',
            'status' => 'nullable|in:pending,done',
            'jatuh_tempo_start' => 'nullable|date',
            'jatuh_tempo_end' => 'nullable|date|after_or_equal:jatuh_tempo_start',
        ]);

        $query = PlannedTransaction::query()->where('user_id', auth()->id());

        // Filter by search (keterangan)
        if ($request->filled('search')) {
            $query->where('keterangan', 'like', '%' . trim($request->search) . '%');
        }

        // Filter by nama
        if ($request->filled('nama')) {
            $query->where('nama', $request->nama);
        }

        // Filter by jenis
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by jatuh_tempo range
        if ($request->filled('jatuh_tempo_start')) {
            $query->whereDate('jatuh_tempo', '>=', $request->jatuh_tempo_start);
        }
        if ($request->filled('jatuh_tempo_end')) {
            $query->whereDate('jatuh_tempo', '<=', $request->jatuh_tempo_end);
        }

        // Eager load relationships
        $query->with(['kategoriNama', 'kategoriJenis']);

        // Paginate results
        $plannedTransactions = $query->latest()->paginate(10)->appends($request->query());

        // Load categories for other views
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
            'nominal' => 'required|numeric|min:0',
            'keterangan' => 'required|string|max:255',
            'jatuh_tempo' => 'required|date',
        ]);

        $validated['user_id'] = auth()->id();
        PlannedTransaction::create($validated);

        return redirect()->route('planned-transactions.index')->with('success', 'Rencana transaksi berhasil ditambahkan.');
    }

    public function edit(PlannedTransaction $plannedTransaction)
    {
        if ($plannedTransaction->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak. Anda hanya bisa mengedit data Anda sendiri.');
        }

        $namaKategori = KategoriNamaTabungan::all();
        $jenisKategori = KategoriJenisTabungan::all();
        return view('planned-transactions.edit', compact('plannedTransaction', 'namaKategori', 'jenisKategori'));
    }

    public function update(Request $request, PlannedTransaction $plannedTransaction)
    {
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
        if ($plannedTransaction->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak. Anda hanya bisa menghapus data Anda sendiri.');
        }

        $plannedTransaction->delete();
        return redirect()->route('planned-transactions.index')->with('success', 'Rencana transaksi berhasil dihapus.');
    }

    public function complete(Request $request, PlannedTransaction $plannedTransaction)
    {
        if ($plannedTransaction->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak. Anda hanya bisa menyelesaikan rencana Anda sendiri.');
        }

        $request->validate(['tanggal_peristiwa' => 'required|date']);

        Tabungan::create([
            'nama' => $plannedTransaction->nama,
            'jenis' => $plannedTransaction->jenis,
            'nominal' => $plannedTransaction->nominal,
            'keterangan' => $plannedTransaction->keterangan . " (Realisasi dari rencana)",
            'user_id' => auth()->id(),
            'created_at' => $request->tanggal_peristiwa,
            'updated_at' => $request->tanggal_peristiwa,
        ]);

        $plannedTransaction->update([
            'status' => 'done',
            'tanggal_peristiwa' => $request->tanggal_peristiwa,
        ]);

        return redirect()->route('planned-transactions.index')->with('success', 'Rencana transaksi berhasil direalisasikan!');
    }
}