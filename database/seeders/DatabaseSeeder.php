<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Pembayaran;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Users (Admin / Bendahara only)
        User::where('role', '!=', 'admin')->delete();

        User::updateOrCreate(
            ['email' => 'salsabila@sekolah.sch.id'],
            [
                'name' => 'Salsabila Putri',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Create Students
        $studentsData = [
            [
                'nis' => '89201',
                'nama' => 'Ahmad Fauzi',
                'jenis_kelamin' => 'L',
                'no_hp' => '0812-9842-1102',
                'nama_wali' => 'Bpk. Hendra Gunawan',
                'target_kas' => 80000,
                'total_terbayar' => 80000,
                'status' => 'lunas',
            ],
            [
                'nis' => '89202',
                'nama' => 'Anisa Nurul',
                'jenis_kelamin' => 'P',
                'no_hp' => '0813-8871-3321',
                'nama_wali' => 'Ibu Siti Aminah',
                'target_kas' => 80000,
                'total_terbayar' => 80000,
                'status' => 'lunas',
            ],
            [
                'nis' => '89203',
                'nama' => 'Budi Pratama',
                'jenis_kelamin' => 'L',
                'no_hp' => '0857-1123-9944',
                'nama_wali' => 'Bpk. Bambang P.',
                'target_kas' => 80000,
                'total_terbayar' => 60000,
                'status' => 'belum_lunas',
            ],
            [
                'nis' => '89204',
                'nama' => 'Citra Rahmawati',
                'jenis_kelamin' => 'P',
                'no_hp' => '0812-3344-5566',
                'nama_wali' => 'Ibu Dewi Lestari',
                'target_kas' => 80000,
                'total_terbayar' => 80000,
                'status' => 'lunas',
            ],
            [
                'nis' => '89205',
                'nama' => 'Dimas Wahyudi',
                'jenis_kelamin' => 'L',
                'no_hp' => '0852-7788-9900',
                'nama_wali' => 'Bpk. Wahyu Hidayat',
                'target_kas' => 80000,
                'total_terbayar' => 40000,
                'status' => 'belum_lunas',
            ],
            [
                'nis' => '89206',
                'nama' => 'Eka Wulandari',
                'jenis_kelamin' => 'P',
                'no_hp' => '0878-9900-1122',
                'nama_wali' => 'Ibu Sri Mulyani',
                'target_kas' => 80000,
                'total_terbayar' => 80000,
                'status' => 'lunas',
            ],
            [
                'nis' => '89207',
                'nama' => 'Fajar Ramadhan',
                'jenis_kelamin' => 'L',
                'no_hp' => '0819-2233-4455',
                'nama_wali' => 'Bpk. Ramadhan S.',
                'target_kas' => 80000,
                'total_terbayar' => 60000,
                'status' => 'belum_lunas',
            ],
        ];

        foreach ($studentsData as $data) {
            $siswa = Siswa::updateOrCreate(['nis' => $data['nis']], $data);

            // Seed Payments for Ahmad Fauzi (4 weeks paid)
            if ($siswa->nis === '89201') {
                for ($w = 1; $w <= 4; $w++) {
                    Pembayaran::updateOrCreate(
                        ['kode_transaksi' => "TRX-2410-{$w}-89201"],
                        [
                            'siswa_id' => $siswa->id,
                            'minggu_ke' => $w,
                            'bulan' => 'Oktober',
                            'tahun' => 2024,
                            'nominal' => 20000,
                            'tanggal_bayar' => "2024-10-" . str_pad($w * 7 - 3, 2, '0', STR_PAD_LEFT),
                            'metode_pembayaran' => $w === 4 ? 'qris' : 'tunai',
                            'status' => 'lunas',
                            'catatan' => "Pembayaran iuran kas minggu ke-{$w} bulan Oktober",
                        ]
                    );
                }
            }
        }

        // 3. Pemasukan Data
        $incomes = [
            [
                'kode_transaksi' => 'IN-2410-01',
                'kategori' => 'Iuran Kas',
                'deskripsi' => 'Iuran Kas Rutin Minggu Ke-1 (36 Siswa)',
                'nominal' => 720000,
                'tanggal' => '2024-10-04',
                'sumber' => 'Kas Mingguan Siswa',
                'penanggung_jawab' => 'Salsabila Putri',
            ],
            [
                'kode_transaksi' => 'IN-2410-02',
                'kategori' => 'Iuran Kas',
                'deskripsi' => 'Iuran Kas Rutin Minggu Ke-2 (36 Siswa)',
                'nominal' => 720000,
                'tanggal' => '2024-10-11',
                'sumber' => 'Kas Mingguan Siswa',
                'penanggung_jawab' => 'Salsabila Putri',
            ],
            [
                'kode_transaksi' => 'IN-2410-03',
                'kategori' => 'Donasi',
                'deskripsi' => 'Donasi Sukarela Fasilitas Kelas dari Alumni',
                'nominal' => 350000,
                'tanggal' => '2024-10-15',
                'sumber' => 'Alumni Angkatan 2022',
                'penanggung_jawab' => 'Salsabila Putri',
            ],
            [
                'kode_transaksi' => 'IN-2410-04',
                'kategori' => 'Iuran Kas',
                'deskripsi' => 'Iuran Kas Rutin Minggu Ke-3 (34 Siswa)',
                'nominal' => 680000,
                'tanggal' => '2024-10-18',
                'sumber' => 'Kas Mingguan Siswa',
                'penanggung_jawab' => 'Salsabila Putri',
            ],
            [
                'kode_transaksi' => 'IN-2410-05',
                'kategori' => 'Usaha Kelas',
                'deskripsi' => 'Keuntungan Bersih Penjualan Makanan Bazar Sekolah',
                'nominal' => 380000,
                'tanggal' => '2024-10-22',
                'sumber' => 'Stand Bazar XII IPA 2',
                'penanggung_jawab' => 'Salsabila Putri',
            ],
        ];

        foreach ($incomes as $inc) {
            Pemasukan::updateOrCreate(['kode_transaksi' => $inc['kode_transaksi']], $inc);
        }

        // 4. Pengeluaran Data
        $expenses = [
            [
                'kode_transaksi' => 'OUT-2410-04',
                'kategori' => 'Perlengkapan Kelas',
                'deskripsi' => 'Spidol Whiteboard 4 Warna & Penghapus Magnet',
                'nominal' => 45000,
                'tanggal' => '2024-10-23',
                'toko_vendor' => 'Toko Buku Gramedia',
                'nomor_nota' => 'INV-GRM-99120',
                'status_verifikasi' => 'terverifikasi',
                'penanggung_jawab' => 'Salsabila Putri',
                'catatan' => 'Untuk kebutuhan mengajar harian guru dan presentasi siswa.',
            ],
            [
                'kode_transaksi' => 'OUT-2410-03',
                'kategori' => 'Akademik & Ujian',
                'deskripsi' => 'Fotokopi Modul Latihan Ujian Fisika 36 Siswa',
                'nominal' => 185000,
                'tanggal' => '2024-10-18',
                'toko_vendor' => 'Fotokopi Berkah Barokah',
                'nomor_nota' => 'NOT-FTO-33411',
                'status_verifikasi' => 'terverifikasi',
                'penanggung_jawab' => 'Salsabila Putri',
                'catatan' => 'Dicetak rangkap 36 lengkap dengan pembahasan soal try out.',
            ],
            [
                'kode_transaksi' => 'OUT-2410-02',
                'kategori' => 'Sosial & Kesehatan',
                'deskripsi' => 'Santunan Dana Sosial dan Parcel Buah (Rico Dimas Sakit)',
                'nominal' => 100000,
                'tanggal' => '2024-10-12',
                'toko_vendor' => 'Keluarga Siswa & Pasar Buah',
                'nomor_nota' => 'KW-SOS-22019',
                'status_verifikasi' => 'terverifikasi',
                'penanggung_jawab' => 'Salsabila Putri',
                'catatan' => 'Diserahkan langsung oleh perwakilan pengurus kelas saat menjenguk di RSUD.',
            ],
            [
                'kode_transaksi' => 'OUT-2410-01',
                'kategori' => 'Kebersihan',
                'deskripsi' => 'Refill Galon Air Minum 2x & Sabun Cuci Tangan Botol',
                'nominal' => 50000,
                'tanggal' => '2024-10-05',
                'toko_vendor' => 'Toko Kelontong Ibu Sri',
                'nomor_nota' => 'NOT-KLN-11002',
                'status_verifikasi' => 'terverifikasi',
                'penanggung_jawab' => 'Salsabila Putri',
                'catatan' => 'Penyediaan air minum galon dan sanitasi kebersihan wastafel kelas.',
            ],
        ];

        foreach ($expenses as $exp) {
            Pengeluaran::updateOrCreate(['kode_transaksi' => $exp['kode_transaksi']], $exp);
        }
    }
}
