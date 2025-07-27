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
        $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'jumlah' => 'required|numeric',
            'keterangan' => 'nullable',
        ]);

        Tabungan::create($request->all());

        return redirect()->route('tabungan.index')->with('success', 'Data berhasil ditambahkan.');
    }
}
