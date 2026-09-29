<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'siswa_id',
        'minggu_ke',
        'bulan',
        'tahun',
        'nominal',
        'tanggal_bayar',
        'metode_pembayaran',
        'status',
        'catatan',
    ];

    protected $casts = [
        'minggu_ke' => 'integer',
        'tahun' => 'integer',
        'nominal' => 'integer',
        'tanggal_bayar' => 'date',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }
}
