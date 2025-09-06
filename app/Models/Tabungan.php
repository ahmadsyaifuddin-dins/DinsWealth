<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tabungan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama',
        'jenis',
        'nominal',
        'keterangan',
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
        'deleted_at' => 'datetime'
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

    // Accessor untuk format nominal
    public function getFormattedNominalAttribute()
    {
        return 'Rp ' . number_format($this->nominal, 0, ',', '.');
    }

    // TAMBAHKAN RELASI BARU INI
    public function images()
    {
        return $this->hasMany(TabunganImage::class);
    }
}
