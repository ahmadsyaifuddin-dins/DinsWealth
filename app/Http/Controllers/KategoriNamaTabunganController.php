<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriNamaTabungan;

class KategoriNamaTabunganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = KategoriNamaTabungan::all();
        return view('kategori.nama-index', compact('data'));
    }

    // Menyimpan kategori baru setelah validasi duplikat
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kategori_nama_tabungans,nama',
        ]);

        KategoriNamaTabungan::create([
            'nama' => $request->nama
        ]);

        return redirect()->route('kategori.nama.index')->with('success', 'Nama Kategori berhasil ditambahkan');
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $kategori = KategoriNamaTabungan::findOrFail($id);
        return view('kategori.nama.edit', compact('kategori'));
    }

    // Memperbarui data kategori setelah validasi duplikat
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kategori_nama_tabungans,nama,' . $id,
        ]);

        $kategori = KategoriNamaTabungan::findOrFail($id);
        $kategori->update([
            'nama' => $request->nama
        ]);

        return redirect()->route('kategori.nama.index')->with('success', 'Nama Kategori berhasil diupdate');
    }

    // Menghapus kategori tabungan
    public function destroy($id)
    {
        $kategori = KategoriNamaTabungan::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.nama.index')->with('success', 'Nama Kategori berhasil dihapus');
    }
}
