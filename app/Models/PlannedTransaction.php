<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlannedTransaction extends Model
{
    use HasFactory;

    /**
     * Atribut yang bisa diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'jenis',
        'nominal',
        'keterangan',
        'jatuh_tempo',
        'tanggal_peristiwa',
        'status',
        'user_id',
    ];

    /**
     * Tipe data atribut yang akan di-cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'jatuh_tempo' => 'date',
        'tanggal_peristiwa' => 'datetime',
    ];

      /**
     * Appends custom attributes to the model's array form.
     *
     * @var array
     */
    protected $appends = ['jatuh_tempo_formatted'];

    /**
     * Accessor untuk mendapatkan jatuh_tempo dalam format Y-m-d.
     *
     * @return string
     */
    public function getJatuhTempoFormattedAttribute()
    {
        return $this->jatuh_tempo->format('Y-m-d');
    }
    

    /**
     * Relasi ke model KategoriNamaTabungan.
     */
    public function kategoriNama()
    {
        return $this->belongsTo(KategoriNamaTabungan::class, 'nama');
    }

    /**
     * Relasi ke model KategoriJenisTabungan.
     */
    public function kategoriJenis()
    {
        return $this->belongsTo(KategoriJenisTabungan::class, 'jenis');
    }

    /**
     * Relasi ke model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}