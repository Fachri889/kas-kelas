<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('siswa:dummy {count=10 : Jumlah siswa dummy yang ingin dibuat}', function ($count = 10) {
    $count = max(1, (int) $count);
    $this->info("Sedang membuat {$count} data siswa dummy...");

    $created = \App\Models\Siswa::factory()->count($count)->withPembayaran()->create();

    $this->table(
        ['NIS', 'Nama', 'JK', 'No HP', 'Kelas', 'Total Terbayar', 'Status'],
        $created->map(fn ($s) => [
            $s->nis,
            $s->nama,
            $s->jenis_kelamin,
            $s->no_hp,
            $s->kelas,
            'Rp ' . number_format($s->total_terbayar, 0, ',', '.'),
            $s->status,
        ])
    );

    $this->info("Berhasil membuat {$count} data siswa dummy beserta riwayat pembayarannya!");
})->purpose('Generate data siswa dummy beserta riwayat pembayaran kas');

