<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriJenisTabungan;

class KategoriJenisTabunganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = KategoriJenisTabungan::all();
        return view('kategori.jenis-index', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|string|max:255|unique:kategori_jenis_tabungans,jenis',
        ]);

        KategoriJenisTabungan::create([
            'jenis' => $request->jenis
        ]);

        return redirect()->route('kategori.jenis.index')->with('success', 'Jenis Kategori berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = KategoriJenisTabungan::findOrFail($id);
        return view('kategori.jenis-show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = KategoriJenisTabungan::findOrFail($id);
        return view('kategori.jenis-edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'jenis' => 'required|string|max:255|unique:kategori_jenis_tabungans,jenis,' . $id,
        ]);

        $kategori = KategoriJenisTabungan::findOrFail($id);
        $kategori->update([
            'jenis' => $request->jenis
        ]);

        return redirect()->route('kategori.jenis.index')->with('success', 'Jenis Kategori berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = KategoriJenisTabungan::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.jenis.index')->with('success', 'Jenis Kategori berhasil dihapus');
    }
}
