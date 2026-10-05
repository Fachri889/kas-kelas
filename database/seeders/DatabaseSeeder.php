<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Pembayaran;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with full admin & student data.
     */
    public function run(): void
    {
        // Disable foreign key checks for clean truncation in SQLite/MySQL
        DB::statement('PRAGMA foreign_keys = OFF;');
        Pembayaran::truncate();
        Siswa::truncate();
        Pemasukan::truncate();
        Pengeluaran::truncate();
        User::truncate();
        DB::statement('PRAGMA foreign_keys = ON;');

        // 1. Create Admin & Bendahara Users
        User::create([
            'name' => 'Salsabila Putri',
            'username' => 'admin',
            'email' => 'salsabila@sekolah.sch.id',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Bintang Pratama',
            'username' => 'bintang',
            'email' => 'bintang@sekolah.sch.id',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // 2. Comprehensive 30 Students Data for Class XII MIPA 2
        $rawStudents = [
            ['nis' => '89201', 'nama' => 'Ahmad Fauzi', 'jk' => 'L', 'hp' => '0812-9842-1102', 'wali' => 'Bpk. Hendra Gunawan', 'weeks' => 4],
            ['nis' => '89202', 'nama' => 'Anisa Nurul', 'jk' => 'P', 'hp' => '0813-8871-3321', 'wali' => 'Ibu Siti Aminah', 'weeks' => 4],
            ['nis' => '89203', 'nama' => 'Budi Pratama', 'jk' => 'L', 'hp' => '0857-1123-9944', 'wali' => 'Bpk. Bambang P.', 'weeks' => 3],
            ['nis' => '89204', 'nama' => 'Citra Rahmawati', 'jk' => 'P', 'hp' => '0812-3344-5566', 'wali' => 'Ibu Dewi Lestari', 'weeks' => 4],
            ['nis' => '89205', 'nama' => 'Dimas Wahyudi', 'jk' => 'L', 'hp' => '0852-7788-9900', 'wali' => 'Bpk. Wahyu Hidayat', 'weeks' => 2],
            ['nis' => '89206', 'nama' => 'Eka Wulandari', 'jk' => 'P', 'hp' => '0878-9900-1122', 'wali' => 'Ibu Sri Mulyani', 'weeks' => 4],
            ['nis' => '89207', 'nama' => 'Fajar Ramadhan', 'jk' => 'L', 'hp' => '0819-2233-4455', 'wali' => 'Bpk. Ramadhan S.', 'weeks' => 3],
            ['nis' => '89208', 'nama' => 'Gita Gutawa', 'jk' => 'P', 'hp' => '0812-5566-7788', 'wali' => 'Bpk. Erwin Gutawa', 'weeks' => 4],
            ['nis' => '89209', 'nama' => 'Hendra Setiawan', 'jk' => 'L', 'hp' => '0813-9900-1122', 'wali' => 'Ibu Maria S.', 'weeks' => 4],
            ['nis' => '89210', 'nama' => 'Indah Permata', 'jk' => 'P', 'hp' => '0856-7788-9900', 'wali' => 'Bpk. Joko W.', 'weeks' => 2],
            ['nis' => '89211', 'nama' => 'Kevin Sanjaya', 'jk' => 'L', 'hp' => '0877-1122-3344', 'wali' => 'Ibu Susi A.', 'weeks' => 4],
            ['nis' => '89212', 'nama' => 'Larasati Putri', 'jk' => 'P', 'hp' => '0818-3344-5566', 'wali' => 'Bpk. Agus P.', 'weeks' => 4],
            ['nis' => '89213', 'nama' => 'Muhammad Rizky', 'jk' => 'L', 'hp' => '0812-4455-6677', 'wali' => 'Bpk. Rizky H.', 'weeks' => 3],
            ['nis' => '89214', 'nama' => 'Nabila Syakieb', 'jk' => 'P', 'hp' => '0813-6677-8899', 'wali' => 'Ibu Syakieb', 'weeks' => 4],
            ['nis' => '89215', 'nama' => 'Oscar Lawalata', 'jk' => 'L', 'hp' => '0858-7788-9911', 'wali' => 'Bpk. Lawalata', 'weeks' => 2],
            ['nis' => '89216', 'nama' => 'Putri Ayudya', 'jk' => 'P', 'hp' => '0878-1122-3344', 'wali' => 'Ibu Ayudya', 'weeks' => 4],
            ['nis' => '89217', 'nama' => 'Qori Sandioriva', 'jk' => 'P', 'hp' => '0819-4455-6677', 'wali' => 'Bpk. Sandioriva', 'weeks' => 4],
            ['nis' => '89218', 'nama' => 'Raditya Dika', 'jk' => 'L', 'hp' => '0812-6677-8899', 'wali' => 'Ibu Dika', 'weeks' => 3],
            ['nis' => '89219', 'nama' => 'Siti Badriah', 'jk' => 'P', 'hp' => '0813-8899-0011', 'wali' => 'Bpk. Badriah', 'weeks' => 4],
            ['nis' => '89220', 'nama' => 'Taufik Hidayat', 'jk' => 'L', 'hp' => '0856-9900-1122', 'wali' => 'Ibu Hidayat', 'weeks' => 4],
            ['nis' => '89221', 'nama' => 'Ulfa Dwiyanti', 'jk' => 'P', 'hp' => '0877-2233-4455', 'wali' => 'Bpk. Dwiyanti', 'weeks' => 3],
            ['nis' => '89222', 'nama' => 'Vidi Aldiano', 'jk' => 'L', 'hp' => '0818-4455-6677', 'wali' => 'Ibu Aldiano', 'weeks' => 4],
            ['nis' => '89223', 'nama' => 'Winda Viska', 'jk' => 'P', 'hp' => '0812-7788-9900', 'wali' => 'Bpk. Viska', 'weeks' => 4],
            ['nis' => '89224', 'nama' => 'Xaverius Frans', 'jk' => 'L', 'hp' => '0813-9900-1122', 'wali' => 'Ibu Frans', 'weeks' => 2],
            ['nis' => '89225', 'nama' => 'Yura Yunita', 'jk' => 'P', 'hp' => '0858-1122-3344', 'wali' => 'Bpk. Yunita', 'weeks' => 4],
            ['nis' => '89226', 'nama' => 'Zaenal Abidin', 'jk' => 'L', 'hp' => '0878-3344-5566', 'wali' => 'Ibu Abidin', 'weeks' => 4],
            ['nis' => '89227', 'nama' => 'Aris Munandar', 'jk' => 'L', 'hp' => '0819-5566-7788', 'wali' => 'Bpk. Munandar', 'weeks' => 3],
            ['nis' => '89228', 'nama' => 'Bella Saphira', 'jk' => 'P', 'hp' => '0812-8899-0011', 'wali' => 'Ibu Saphira', 'weeks' => 4],
            ['nis' => '89229', 'nama' => 'Cakra Khan', 'jk' => 'L', 'hp' => '0813-1122-3344', 'wali' => 'Bpk. Khan', 'weeks' => 4],
            ['nis' => '89230', 'nama' => 'Dina Olivia', 'jk' => 'P', 'hp' => '0856-4455-6677', 'wali' => 'Ibu Olivia', 'weeks' => 4],
        ];

        foreach ($rawStudents as $st) {
            $paidWeeks = $st['weeks'];
            $totalTerbayar = $paidWeeks * 5000;
            $status = ($totalTerbayar >= 20000) ? 'lunas' : 'belum_lunas';

            $siswa = Siswa::create([
                'nis' => $st['nis'],
                'nama' => $st['nama'],
                'jenis_kelamin' => $st['jk'],
                'no_hp' => $st['hp'],
                'nama_wali' => $st['wali'],
                'kelas' => 'XII MIPA 2',
                'target_kas' => 20000,
                'total_terbayar' => $totalTerbayar,
                'status' => $status,
            ]);

            // Create payment transactions for each paid week
            for ($w = 1; $w <= $paidWeeks; $w++) {
                $day = str_pad($w * 7 - 3, 2, '0', STR_PAD_LEFT);
                $metode = ($w % 3 == 0) ? 'qris' : (($w % 2 == 0) ? 'transfer' : 'tunai');
                
                Pembayaran::create([
                    'kode_transaksi' => "TRX-2410-W{$w}-{$st['nis']}",
                    'siswa_id' => $siswa->id,
                    'minggu_ke' => $w,
                    'bulan' => 'Oktober',
                    'tahun' => 2024,
                    'nominal' => 5000,
                    'tanggal_bayar' => "2024-10-{$day}",
                    'metode_pembayaran' => $metode,
                    'status' => 'lunas',
                    'catatan' => "Iuran kas minggu ke-{$w} bulan Oktober 2024",
                ]);
            }
        }

        // 3. Complete Incomes (Pemasukan)
        $incomes = [
            [
                'kode_transaksi' => 'IN-2410-01',
                'kategori' => 'Sisa Kas',
                'deskripsi' => 'Saldo Sisa Kas Kelas Bulan September 2024',
                'nominal' => 450000,
                'tanggal' => '2024-10-01',
                'sumber' => 'Kas Bulan Lalu',
                'penanggung_jawab' => 'Salsabila Putri',
            ],
            [
                'kode_transaksi' => 'IN-2410-02',
                'kategori' => 'Iuran Kas',
                'deskripsi' => 'Iuran Kas Rutin Minggu Ke-1 Oktober (30 Siswa)',
                'nominal' => 600000,
                'tanggal' => '2024-10-04',
                'sumber' => 'Kas Mingguan Siswa',
                'penanggung_jawab' => 'Salsabila Putri',
            ],
            [
                'kode_transaksi' => 'IN-2410-03',
                'kategori' => 'Iuran Kas',
                'deskripsi' => 'Iuran Kas Rutin Minggu Ke-2 Oktober (30 Siswa)',
                'nominal' => 600000,
                'tanggal' => '2024-10-11',
                'sumber' => 'Kas Mingguan Siswa',
                'penanggung_jawab' => 'Salsabila Putri',
            ],
            [
                'kode_transaksi' => 'IN-2410-04',
                'kategori' => 'Donasi',
                'deskripsi' => 'Donasi Sukarela Fasilitas Kelas dari Alumni Angkatan 2022',
                'nominal' => 350000,
                'tanggal' => '2024-10-15',
                'sumber' => 'Alumni Angkatan 2022',
                'penanggung_jawab' => 'Bintang Pratama',
            ],
            [
                'kode_transaksi' => 'IN-2410-05',
                'kategori' => 'Iuran Kas',
                'deskripsi' => 'Iuran Kas Rutin Minggu Ke-3 Oktober (24 Siswa)',
                'nominal' => 480000,
                'tanggal' => '2024-10-18',
                'sumber' => 'Kas Mingguan Siswa',
                'penanggung_jawab' => 'Salsabila Putri',
            ],
            [
                'kode_transaksi' => 'IN-2410-06',
                'kategori' => 'Usaha Kelas',
                'deskripsi' => 'Keuntungan Bersih Penjualan Makanan Stand Bazar Sekolah',
                'nominal' => 380000,
                'tanggal' => '2024-10-22',
                'sumber' => 'Stand Bazar XII MIPA 2',
                'penanggung_jawab' => 'Bintang Pratama',
            ],
            [
                'kode_transaksi' => 'IN-2410-07',
                'kategori' => 'Iuran Kas',
                'deskripsi' => 'Iuran Kas Rutin Minggu Ke-4 Oktober (20 Siswa)',
                'nominal' => 400000,
                'tanggal' => '2024-10-25',
                'sumber' => 'Kas Mingguan Siswa',
                'penanggung_jawab' => 'Salsabila Putri',
            ],
            [
                'kode_transaksi' => 'IN-2410-08',
                'kategori' => 'Lomba',
                'deskripsi' => 'Hadiah Juara 1 Lomba Kebersihan & Kerapihan Kelas',
                'nominal' => 500000,
                'tanggal' => '2024-10-28',
                'sumber' => 'Panitia OSIS Sekolah',
                'penanggung_jawab' => 'Salsabila Putri',
            ],
        ];

        foreach ($incomes as $inc) {
            Pemasukan::create($inc);
        }

        // 4. Complete Expenses (Pengeluaran)
        $expenses = [
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
            [
                'kode_transaksi' => 'OUT-2410-02',
                'kategori' => 'Sosial & Kesehatan',
                'deskripsi' => 'Santunan Dana Sosial dan Parcel Buah (Siswa Sakit)',
                'nominal' => 100000,
                'tanggal' => '2024-10-12',
                'toko_vendor' => 'Keluarga Siswa & Pasar Buah',
                'nomor_nota' => 'KW-SOS-22019',
                'status_verifikasi' => 'terverifikasi',
                'penanggung_jawab' => 'Bintang Pratama',
                'catatan' => 'Diserahkan langsung saat menjenguk di rumah sakit.',
            ],
            [
                'kode_transaksi' => 'OUT-2410-03',
                'kategori' => 'Akademik & Ujian',
                'deskripsi' => 'Fotokopi Modul Latihan Ujian Fisika 30 Siswa',
                'nominal' => 185000,
                'tanggal' => '2024-10-18',
                'toko_vendor' => 'Fotokopi Berkah Barokah',
                'nomor_nota' => 'NOT-FTO-33411',
                'status_verifikasi' => 'terverifikasi',
                'penanggung_jawab' => 'Salsabila Putri',
                'catatan' => 'Dicetak rangkap 30 lengkap dengan pembahasan soal try out.',
            ],
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
                'kode_transaksi' => 'OUT-2410-05',
                'kategori' => 'Kebersihan',
                'deskripsi' => 'Sapu Ijuk 2 Pcs, Kemoceng & Lap Microfiber',
                'nominal' => 85000,
                'tanggal' => '2024-10-24',
                'toko_vendor' => 'Toko Bangunan Sentosa',
                'nomor_nota' => 'INV-ST-44912',
                'status_verifikasi' => 'terverifikasi',
                'penanggung_jawab' => 'Bintang Pratama',
                'catatan' => 'Peralatan piket kebersihan harian kelas XII MIPA 2.',
            ],
            [
                'kode_transaksi' => 'OUT-2410-06',
                'kategori' => 'Dekorasi Kelas',
                'deskripsi' => 'Taplak Meja Guru & Jam Dinding Kelas',
                'nominal' => 95000,
                'tanggal' => '2024-10-26',
                'toko_vendor' => 'Toko Aksesoris Pelangi',
                'nomor_nota' => 'INV-PLG-00213',
                'status_verifikasi' => 'terverifikasi',
                'penanggung_jawab' => 'Salsabila Putri',
                'catatan' => 'Mempercantik kerapihan meja mengajar guru.',
            ],
            [
                'kode_transaksi' => 'OUT-2410-07',
                'kategori' => 'Dekorasi Kelas',
                'deskripsi' => 'Cetak Banner Struktur Organisasi Kelas XII MIPA 2',
                'nominal' => 120000,
                'tanggal' => '2024-10-27',
                'toko_vendor' => 'Digital Print Pro',
                'nomor_nota' => 'INV-DPP-8812',
                'status_verifikasi' => 'terverifikasi',
                'penanggung_jawab' => 'Bintang Pratama',
                'catatan' => 'Dipasang di papan informasi belakang kelas.',
            ],
            [
                'kode_transaksi' => 'OUT-2410-08',
                'kategori' => 'Perlengkapan Kelas',
                'deskripsi' => 'Pigura Foto Presiden & Vice President 1 Set',
                'nominal' => 110000,
                'tanggal' => '2024-10-29',
                'toko_vendor' => 'Toko Bingkai Indah',
                'nomor_nota' => 'INV-BKI-1092',
                'status_verifikasi' => 'terverifikasi',
                'penanggung_jawab' => 'Salsabila Putri',
                'catatan' => 'Penggantian pigura resmi dinding depan kelas.',
            ],
        ];

        foreach ($expenses as $exp) {
            Pengeluaran::create($exp);
        }
    }
}
