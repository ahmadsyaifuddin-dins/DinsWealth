<?php

namespace App\Http\Controllers;

use App\Models\Tabungan;
use Illuminate\Http\Request;
use App\Services\AiTransactionParser; // Pastikan ini ter-import
use App\Models\KategoriJenisTabungan;
use App\Models\KategoriNamaTabungan; // Tambahkan ini

class QuickCaptureController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'raw_text' => 'required|string|max:500', // Agak panjangin dikit max-nya
            'wallet_id' => 'required|exists:kategori_nama_tabungans,id'
        ]);

        // 1. Panggil AI Parser (Logic yang sama dengan Bot Telegram)
        $parser = new AiTransactionParser();
        $parsedData = $parser->parseText($request->raw_text);

        if (empty($parsedData)) {
            return back()->with('error', 'Waduh, AI bingung bacanya. Coba kalimat yang lebih simpel ya beb! 🤔');
        }

        $count = 0;
        $totalNominal = 0;
        
        // Cache ID Jenis biar hemat query
        $idMasuk = KategoriJenisTabungan::where('jenis', 'Pemasukan')->value('id') ?? 1;
        $idKeluar = KategoriJenisTabungan::where('jenis', 'Pengeluaran')->value('id') ?? 2;

        foreach ($parsedData as $item) {
            // Validasi nominal harus ada dan positif
            if (!isset($item['nominal']) || $item['nominal'] <= 0) continue;

            // Tentukan Jenis (Pemasukan/Pengeluaran)
            // AI mengembalikan string 'Pemasukan' atau 'Pengeluaran'
            $jenisId = ($item['jenis'] ?? 'Pengeluaran') === 'Pemasukan' ? $idMasuk : $idKeluar;

            // Simpan ke DB
            Tabungan::create([
                'nama' => $request->wallet_id, // ID Dompet/Sumber Dana
                'jenis' => $jenisId,
                'nominal' => $item['nominal'],
                'keterangan' => ($item['keterangan'] ?? 'Transaksi Tanpa Nama') . ' (via Quick Add)',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $count++;
            $totalNominal += $item['nominal'];
        }

        // Format Rupiah untuk pesan sukses
        $formattedTotal = number_format($totalNominal, 0, ',', '.');
        
        return back()->with('success', "Siap! {$count} transaksi berhasil dicatat. Total: Rp {$formattedTotal}. Makin rapi deh keuangannya! 😘");
    }
}