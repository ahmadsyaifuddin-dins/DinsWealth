<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabunganImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'tabungan_id',
        'path',
    ];

    public function tabungan()
    {
        return $this->belongsTo(Tabungan::class);
    }
}