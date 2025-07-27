<?php

namespace App\Http\Controllers;

use App\Models\Tabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TabunganController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'dins') {
            // Dins bisa lihat semua data tabungan
            $data = Tabungan::with('user')->latest()->get();
        } elseif ($user->role === 'viewer') {
            // Viewer cuma bisa lihat tabungan milik sendiri
            $data = Tabungan::latest()->get();
        } else {
            abort(403);
        }

        return view('tabungan.index', compact('data', 'user'));
    }

    public function create()
    {
        return view('tabungan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'nominal' => 'required',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Hapus titik/koma dari nominal
        $cleanedNominal = str_replace(['.', ','], '', $validated['nominal']);

        Tabungan::create([
            'nama' => $validated['nama'],
            'jenis' => $validated['jenis'],
            'nominal' => $cleanedNominal,
            'keterangan' => $validated['keterangan'],
            // Tambahkan field lain jika perlu
        ]);

        return redirect()->route('tabungan.index')->with('success', 'Tabungan berhasil ditambahkan.');
    }
}
