<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KategoriNamaTabungan;
use App\Models\KategoriJenisTabungan;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        KategoriNamaTabungan::insert([
            ['nama' => 'Tabungan Bulanan'],
            ['nama' => 'Tabungan Seabank'],
            ['nama' => 'Dana Darurat'], 
        ]);

        KategoriJenisTabungan::insert([
            ['jenis' => 'Pemasukan'],
            ['jenis' => 'Pengeluaran']
        ]);
    }
}

