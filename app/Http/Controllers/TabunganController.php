<?php

namespace App\Http\Controllers;

use App\Models\Tabungan;
use App\Models\KategoriNamaTabungan;
use App\Models\KategoriJenisTabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TabunganController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'dins') {
            // Dins bisa lihat semua data tabungan
            $data = Tabungan::with(['user', 'kategoriNama', 'kategoriJenis'])->latest()->get();
        } elseif ($user->role === 'viewer') {
            // Viewer cuma bisa lihat tabungan milik sendiri
            $data = Tabungan::with(['user', 'kategoriNama', 'kategoriJenis'])->latest()->get();
        } else {
            abort(403);
        }

        $namaKategori = KategoriNamaTabungan::all();
        $jenisKategori = KategoriJenisTabungan::all();
        return view('tabungan.index', compact('data', 'user', 'namaKategori', 'jenisKategori'));

    }

    public function create()
    {
        $namaKategori = KategoriNamaTabungan::all();
        $jenisKategori = KategoriJenisTabungan::all();
        return view('tabungan.create', compact('namaKategori', 'jenisKategori'));
    }

    public function store(Request $request)
    {
    $validated = $request->validate([
        'nama' => 'required|exists:kategori_nama_tabungans,id',
        'jenis' => 'required|exists:kategori_jenis_tabungans,id',
        'nominal' => 'required|string', // format-nya akan dibersihkan manual
        'keterangan' => 'nullable|string|max:255',
    ]);

    // Bersihkan angka nominal dari titik/koma agar bisa disimpan sebagai integer
    $cleanedNominal = (int) str_replace(['.', ','], '', $validated['nominal']);

    Tabungan::create([
        'nama' => $validated['nama'],         // ini ID kategori nama tabungan
        'jenis' => $validated['jenis'],       // ini ID kategori jenis tabungan
        'nominal' => $cleanedNominal,
        'keterangan' => $validated['keterangan'],
        'user_id' => auth()->id(),            // supaya tercatat siapa yang nabung
    ]);

    return redirect()->route('tabungan.index')->with('success', 'Tabungan berhasil ditambahkan.');
}

}
