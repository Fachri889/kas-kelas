<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'kategori',
        'deskripsi',
        'nominal',
        'tanggal',
        'toko_vendor',
        'nomor_nota',
        'status_verifikasi',
        'penanggung_jawab',
        'catatan',
    ];

    protected $casts = [
        'nominal' => 'integer',
        'tanggal' => 'date',
    ];
}
