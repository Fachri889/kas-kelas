<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasukan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'kategori',
        'deskripsi',
        'nominal',
        'tanggal',
        'sumber',
        'penanggung_jawab',
    ];

    protected $casts = [
        'nominal' => 'integer',
        'tanggal' => 'date',
    ];
}
