<?php

namespace Database\Seeders;

use App\Models\Pembayaran;
use App\Models\Siswa;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds for dummy student data.
     */
    public function run(): void
    {
        $students = [
            ['nis' => '89301', 'nama' => 'Aditya Pratama', 'jk' => 'L', 'hp' => '0812-1122-3301', 'wali' => 'Bpk. Hendro Pratama', 'weeks' => 4],
            ['nis' => '89302', 'nama' => 'Aulia Maharani', 'jk' => 'P', 'hp' => '0813-2233-4402', 'wali' => 'Ibu Ratna Dewi', 'weeks' => 4],
            ['nis' => '89303', 'nama' => 'Bagas Saputra', 'jk' => 'L', 'hp' => '0857-3344-5503', 'wali' => 'Bpk. Joko Saputra', 'weeks' => 3],
            ['nis' => '89304', 'nama' => 'Cantika Putri', 'jk' => 'P', 'hp' => '0821-4455-6604', 'wali' => 'Ibu Maya Indah', 'weeks' => 4],
            ['nis' => '89305', 'nama' => 'Daffa Maulana', 'jk' => 'L', 'hp' => '0852-5566-7705', 'wali' => 'Bpk. Ahmad Maulana', 'weeks' => 2],
            ['nis' => '89306', 'nama' => 'Dinda Kirana', 'jk' => 'P', 'hp' => '0878-6677-8806', 'wali' => 'Ibu Sri Lestari', 'weeks' => 4],
            ['nis' => '89307', 'nama' => 'Farhan Alamsyah', 'jk' => 'L', 'hp' => '0819-7788-9907', 'wali' => 'Bpk. Deni Alamsyah', 'weeks' => 1],
            ['nis' => '89308', 'nama' => 'Gisella Anastasia', 'jk' => 'P', 'hp' => '0896-8899-0008', 'wali' => 'Ibu Linda Susanti', 'weeks' => 4],
            ['nis' => '89309', 'nama' => 'Hafiz Ramadhan', 'jk' => 'L', 'hp' => '0812-9900-1109', 'wali' => 'Bpk. Ruslan Ramadhan', 'weeks' => 3],
            ['nis' => '89310', 'nama' => 'Intan Nuraini', 'jk' => 'P', 'hp' => '0813-0011-2210', 'wali' => 'Ibu Nurhayati', 'weeks' => 4],
            ['nis' => '89311', 'nama' => 'Jonathan Surya', 'jk' => 'L', 'hp' => '0857-1122-3311', 'wali' => 'Bpk. Surya Wijaya', 'weeks' => 4],
            ['nis' => '89312', 'nama' => 'Keisha Aurelia', 'jk' => 'P', 'hp' => '0821-2233-4412', 'wali' => 'Ibu Diana Kusuma', 'weeks' => 0],
            ['nis' => '89313', 'nama' => 'Lutfi Hakim', 'jk' => 'L', 'hp' => '0852-3344-5513', 'wali' => 'Bpk. Lukman Hakim', 'weeks' => 2],
            ['nis' => '89314', 'nama' => 'Mega Safitri', 'jk' => 'P', 'hp' => '0878-4455-6614', 'wali' => 'Ibu Endang Safitri', 'weeks' => 4],
            ['nis' => '89315', 'nama' => 'Naufal Zaidan', 'jk' => 'L', 'hp' => '0819-5566-7715', 'wali' => 'Bpk. Anwar Zaidan', 'weeks' => 4],
        ];

        foreach ($students as $st) {
            $paidWeeks = $st['weeks'];
            $totalTerbayar = $paidWeeks * 5000;
            $status = ($totalTerbayar >= 20000) ? 'lunas' : 'belum_lunas';

            $siswa = Siswa::updateOrCreate(
                ['nis' => $st['nis']],
                [
                    'nama' => $st['nama'],
                    'jenis_kelamin' => $st['jk'],
                    'no_hp' => $st['hp'],
                    'nama_wali' => $st['wali'],
                    'kelas' => 'XII MIPA 2',
                    'target_kas' => 20000,
                    'total_terbayar' => $totalTerbayar,
                    'status' => $status,
                ]
            );

            // Buat data riwayat transaksi pembayaran sesuai minggu terbayar
            for ($w = 1; $w <= $paidWeeks; $w++) {
                $day = str_pad((string) ($w * 7 - 3), 2, '0', STR_PAD_LEFT);
                $metode = ($w % 3 === 0) ? 'qris' : (($w % 2 === 0) ? 'transfer' : 'tunai');
                $kodeTransaksi = "TRX-2410-W{$w}-{$st['nis']}";

                Pembayaran::updateOrCreate(
                    ['kode_transaksi' => $kodeTransaksi],
                    [
                        'siswa_id' => $siswa->id,
                        'minggu_ke' => $w,
                        'bulan' => 'Oktober',
                        'tahun' => 2024,
                        'nominal' => 5000,
                        'tanggal_bayar' => "2024-10-{$day}",
                        'metode_pembayaran' => $metode,
                        'status' => 'lunas',
                        'catatan' => "Iuran kas minggu ke-{$w} bulan Oktober 2024",
                    ]
                );
            }
        }
    }
}
