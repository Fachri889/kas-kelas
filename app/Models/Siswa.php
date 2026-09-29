<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nis',
        'nama',
        'jenis_kelamin',
        'no_hp',
        'nama_wali',
        'kelas',
        'target_kas',
        'total_terbayar',
        'status',
    ];

    protected $casts = [
        'target_kas' => 'integer',
        'total_terbayar' => 'integer',
    ];

    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function getSisaKasAttribute(): int
    {
        return max(0, $this->target_kas - $this->total_terbayar);
    }

    public function getInitialsAttribute(): string
    {
        $words = explode(' ', trim($this->nama));
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($this->nama, 0, 2));
    }
}
