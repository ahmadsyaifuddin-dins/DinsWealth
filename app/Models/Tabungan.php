<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tabungan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jenis',
        'nominal',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategoriNama()
    {
        return $this->belongsTo(KategoriNamaTabungan::class, 'nama'); // kolom 'nama' sekarang foreign key
    }

    public function kategoriJenis()
    {
        return $this->belongsTo(KategoriJenisTabungan::class, 'jenis'); // kolom 'jenis' sekarang foreign key
    }
}
