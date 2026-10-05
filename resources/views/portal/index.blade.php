@extends('layouts.app')

@section('title', 'Portal Transparansi Siswa & Wali Murid')

@section('content')
<div class="flex flex-col w-full">
    <!-- Hero Banner for Student Portal -->
    <div class="relative w-full overflow-hidden rounded-2xl bg-gradient-to-r from-primary via-primary-container to-surface-tint text-on-primary p-space-lg md:p-space-xl shadow-lg">
        <div class="absolute -right-16 -top-24 w-80 h-80 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
        <div class="absolute right-1/4 -bottom-20 w-60 h-60 rounded-full bg-secondary-fixed/20 blur-xl pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-space-lg">
            <div class="space-y-space-sm max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md text-on-primary">
                    <span class="w-2 h-2 rounded-full bg-secondary-fixed animate-ping"></span>
                    <span class="font-label-sm text-label-sm uppercase tracking-wider">Portal Transparansi Siswa & Wali Murid</span>
                </div>
                
                <h1 class="font-display-lg text-display-lg text-white leading-tight">
                    Halo, {{ $siswa ? $siswa->nama : 'Siswa Kas' }}!
                </h1>
                
                <p class="font-body-lg text-body-lg text-primary-fixed leading-relaxed">
                    Welcome di portal keuangan terbuka kelas <strong>{{ $siswa ? $siswa->kelas : 'XII MIPA 2' }}</strong>. Semua aliran kas tercatat secara real-time demi akuntabilitas bersama.
                </p>
                
                <div class="flex flex-wrap items-center gap-space-sm pt-2">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full {{ ($siswa && $siswa->status === 'lunas') ? 'bg-secondary-fixed/30 text-white' : 'bg-error/30 text-white' }} backdrop-blur-sm">
                        <span class="material-symbols-outlined text-[18px] text-secondary-fixed" style="font-variation-settings: 'FILL' 1;">
                            {{ ($siswa && $siswa->status === 'lunas') ? 'verified' : 'info' }}
                        </span>
                        <span class="font-label-md text-label-md">
                            Status Kas Pribadi: {{ ($siswa && $siswa->status === 'lunas') ? 'LUNAS SEMUA MINGGU' : 'BELUM LUNAS' }}
                        </span>
                    </div>
                    <span class="font-label-sm text-label-sm text-primary-fixed bg-white/10 px-3 py-1.5 rounded-full">
                        {{ ($siswa && $siswa->sisa_kas <= 0) ? 'Nol Tunggakan (Rp 0)' : 'Sisa Tunggakan: Rp ' . number_format($siswa ? $siswa->sisa_kas : 0, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <!-- Action Buttons & Quick Student Switcher -->
            <div class="flex flex-col sm:flex-row lg:flex-col gap-space-sm shrink-0">
                <!-- Dropdown Switch Student -->
                <div class="bg-white/10 backdrop-blur-md rounded-xl p-2.5 border border-white/20">
                    <label for="pilih-siswa" class="block text-white text-xs font-label-sm mb-1">Cek Data Siswa Lain:</label>
                    <select id="pilih-siswa" class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm py-2 px-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary" onchange="window.location.href='{{ route('siswa.dashboard') }}?nis=' + this.value">
                        @foreach($allStudents as $st)
                            <option value="{{ $st->nis }}" {{ ($siswa && $siswa->nis === $st->nis) ? 'selected' : '' }}>
                                {{ $st->nama }} - {{ ucfirst($st->status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button class="inline-flex items-center justify-center gap-2.5 px-6 py-3 rounded-xl bg-surface-container-lowest text-primary shadow-md hover:bg-surface-bright active:scale-95 transition-all duration-200" id="btn-download-kartu">
                    <span class="material-symbols-outlined text-[20px]">file_download</span>
                    <span class="font-label-lg text-label-lg">Unduh Kartu Iuran Digital (PDF)</span>
                </button>
                <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Bendahara, saya ingin konfirmasi kas untuk siswa ' . ($siswa ? $siswa->nama : '')) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white backdrop-blur-sm transition-all duration-200">
                    <span class="material-symbols-outlined text-[18px]">share</span>
                    <span class="font-label-md text-label-md">Kirim Salinan ke WhatsApp Wali Murid</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Section 1: Ringkasan Kas Publik Kelas -->
    <section class="mt-space-xl">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-space-xs mb-space-md">
            <div>
                <div class="flex items-center gap-2 text-primary">
                    <span class="material-symbols-outlined text-[20px]">pie_chart</span>
                    <span class="font-label-md text-label-md uppercase tracking-wider">Ringkasan Kas Publik</span>
                </div>
                <h2 class="font-headline-lg text-headline-lg text-on-surface">Transparansi Saldo Kelas XII MIPA 2</h2>
            </div>
            <span class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-secondary"></span> Update Terakhir: {{ now()->translatedFormat('d F Y, H:i') }} WIB
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-space-md">
            <!-- Card 1: Saldo Kas Bersih -->
            <div class="relative overflow-hidden rounded-2xl bg-surface-container-lowest p-space-lg shadow-sm flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Saldo Kas Bersih Saat Ini</span>
                        <div class="mt-1 font-currency-stat text-currency-stat text-primary">
                            Rp {{ number_format($saldoKas, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-primary-fixed flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[26px]">account_balance</span>
                    </div>
                </div>
                <div class="mt-space-md pt-space-sm bg-surface-container-low rounded-xl p-3 flex items-center gap-2.5">
                    <span class="material-symbols-outlined text-secondary text-[20px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                    <p class="font-label-sm text-label-sm text-on-surface-variant leading-snug">
                        Telah diverifikasi silang oleh <strong>Dra. Hj. Nurjanah (Wali Kelas)</strong> & Bendahara.
                    </p>
                </div>
            </div>

            <!-- Card 2: Total Pemasukan & Partisipasi -->
            <div class="relative overflow-hidden rounded-2xl bg-surface-container-lowest p-space-lg shadow-sm flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Total Pemasukan Kas</span>
                        <div class="mt-1 font-currency-stat text-currency-stat text-secondary">
                            + Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-secondary-fixed/40 flex items-center justify-center text-secondary">
                        <span class="material-symbols-outlined text-[26px]">trending_up</span>
                    </div>
                </div>
                <div class="mt-space-md">
                    <div class="flex justify-between items-center mb-1.5">
                        <span class="font-label-sm text-label-sm text-on-surface-variant">Partisipasi Siswa Lunas</span>
                        <span class="font-label-md text-label-md text-secondary font-semibold">{{ $siswaLunasCount }} dari {{ $totalSiswa }} Siswa ({{ $partisipasiPersen }}%)</span>
                    </div>
                    <div class="w-full h-2 rounded-full bg-surface-container-high overflow-hidden">
                        <div class="h-full bg-secondary rounded-full" style="width: {{ min(100, $partisipasiPersen) }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Total Pengeluaran -->
            <div class="relative overflow-hidden rounded-2xl bg-surface-container-lowest p-space-lg shadow-sm flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Total Belanja & Pengeluaran</span>
                        <div class="mt-1 font-currency-stat text-currency-stat text-error">
                            - Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-error-container/60 flex items-center justify-center text-error">
                        <span class="material-symbols-outlined text-[26px]">shopping_cart_checkout</span>
                    </div>
                </div>
                <div class="mt-space-md flex items-center justify-between pt-space-xs">
                    <span class="font-label-sm text-label-sm text-on-surface-variant">Total {{ $pengeluarans->count() }} Transaksi Kebutuhan Kelas</span>
                    <span class="font-label-sm text-label-sm text-error bg-error-container/40 px-2.5 py-1 rounded-md font-semibold">Nota Terlampir</span>
                </div>
            </div>
        </div>

        <!-- Alokasi Pengeluaran Kas -->
        <div class="mt-space-md rounded-2xl bg-surface-container-lowest p-space-lg shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-sm mb-space-md pb-space-sm border-b border-outline-variant/20">
                <div>
                    <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold">Untuk Apa Uang Kas Kita Digunakan?</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">Rincian mutasi pengeluaran kelas yang transparan dan dapat dipertanggungjawabkan.</p>
                </div>
                <span class="inline-flex items-center gap-1.5 font-label-sm text-label-sm text-primary bg-primary-fixed/40 px-3 py-1 rounded-full w-fit">
                    <span class="material-symbols-outlined text-[16px]">visibility</span> Laporan Terbuka Untuk Umum
                </span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
                @forelse($pengeluarans->take(3) as $png)
                    <div class="rounded-xl bg-surface-container-low p-space-md space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-[20px]">
                                    {{ $png->kategori === 'atk' ? 'cleaning_services' : ($png->kategori === 'kegiatan' ? 'event' : ($png->kategori === 'sosial' ? 'favorite' : 'receipt')) }}
                                </span>
                                <span class="font-label-lg text-label-lg text-on-surface font-semibold">{{ $png->judul }}</span>
                            </div>
                            <span class="font-label-sm text-label-sm bg-primary-fixed text-primary px-2 py-0.5 rounded capitalize">{{ $png->kategori }}</span>
                        </div>
                        <div class="font-headline-sm text-headline-sm text-on-surface font-bold">
                            Rp {{ number_format($png->jumlah, 0, ',', '.') }}
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-2">{{ $png->deskripsi ?? 'Pengeluaran resmi kelas XII MIPA 2.' }}</p>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-4 text-outline font-body-sm">Belum ada data pengeluaran.</div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Section 2: Status Iuran Pribadi Siswa -->
    <section class="mt-space-xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-space-xs mb-space-md">
            <div>
                <div class="flex items-center gap-2 text-primary">
                    <span class="material-symbols-outlined text-[20px]">event_available</span>
                    <span class="font-label-md text-label-md uppercase tracking-wider">Iuran Siswa</span>
                </div>
                <h2 class="font-headline-lg text-headline-lg text-on-surface">Status Iuran Pribadi {{ $siswa ? $siswa->nama : '-' }}</h2>
            </div>
            <div class="flex items-center gap-3">
                <div class="px-3 py-1.5 rounded-lg bg-surface-container-low text-on-surface">
                    <span class="font-body-sm text-body-sm text-on-surface-variant">Total Dibayar: </span>
                    <span class="font-label-lg text-label-lg text-secondary font-bold">Rp {{ number_format($siswa ? $siswa->total_terbayar : 0, 0, ',', '.') }}</span>
                </div>
                <div class="px-3 py-1.5 rounded-lg bg-surface-container-low text-on-surface">
                    <span class="font-body-sm text-body-sm text-on-surface-variant">Tunggakan: </span>
                    <span class="font-label-lg text-label-lg text-on-surface font-bold">Rp {{ number_format($siswa ? $siswa->sisa_kas : 0, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Weekly Card breakdown -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
            @php
                $mingguList = [
                    ['minggu' => 1, 'label' => 'Minggu 1', 'nominal' => 5000],
                    ['minggu' => 2, 'label' => 'Minggu 2', 'nominal' => 5000],
                    ['minggu' => 3, 'label' => 'Minggu 3', 'nominal' => 5000],
                    ['minggu' => 4, 'label' => 'Minggu 4', 'nominal' => 5000],
                ];
                $pembayaransByMinggu = $siswa ? $siswa->pembayarans->keyBy('minggu_ke') : collect();
            @endphp

            @foreach($mingguList as $m)
                @php
                    $pmb = $pembayaransByMinggu->get($m['minggu']);
                    $isLunas = $pmb && $pmb->status === 'lunas';
                @endphp
                <div class="rounded-2xl bg-surface-container-lowest p-space-md shadow-sm relative overflow-hidden flex flex-col justify-between">
                    <div class="absolute top-0 left-0 right-0 h-1.5 {{ $isLunas ? 'bg-secondary' : 'bg-outline-variant' }}"></div>
                    <div>
                        <span class="font-label-sm text-label-sm uppercase text-on-surface-variant">{{ $m['label'] }}</span>
                        <h4 class="font-headline-sm text-headline-sm text-on-surface mt-0.5">Iuran Kas Wajib</h4>
                        <p class="font-label-lg text-label-lg text-on-surface font-bold mt-2">Rp {{ number_format($m['nominal'], 0, ',', '.') }}</p>
                    </div>
                    <div class="mt-space-md">
                        @if($isLunas)
                            <span class="inline-flex items-center gap-1 w-full justify-center py-1.5 rounded-full bg-secondary-fixed/30 text-secondary font-label-sm text-label-sm font-semibold">
                                <span class="material-symbols-outlined text-[14px]">check</span> Lunas ({{ \Carbon\Carbon::parse($pmb->tanggal_bayar)->translatedFormat('d M') }})
                            </span>
                        @else
                            <a href="{{ route('pembayaran.index') }}" class="inline-flex items-center gap-1 w-full justify-center py-1.5 rounded-full bg-primary text-on-primary hover:bg-primary-container font-label-sm text-label-sm font-semibold transition-colors shadow-xs">
                                Bayar Sekarang
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 3: Riwayat Transaksi Siswa & Kontak Bendahara -->
    <div class="mt-space-xl grid grid-cols-1 xl:grid-cols-3 gap-space-lg items-start">
        <div class="xl:col-span-2 space-y-space-md">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2 text-primary">
                        <span class="material-symbols-outlined text-[20px]">receipt_long</span>
                        <span class="font-label-md text-label-md uppercase tracking-wider">Catatan Kas</span>
                    </div>
                    <h2 class="font-headline-lg text-headline-lg text-on-surface">Riwayat Transaksi & Kuitansi Digital</h2>
                </div>
                <span class="font-label-sm text-label-sm text-on-surface-variant">
                    Menampilkan {{ $siswa ? $siswa->pembayarans->count() : 0 }} Transaksi
                </span>
            </div>

            <div class="overflow-hidden rounded-2xl bg-surface-container-lowest shadow-sm border border-outline-variant/30">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">
                                <th class="py-3 px-space-md">No. Transaksi</th>
                                <th class="py-3 px-space-md">Keterangan</th>
                                <th class="py-3 px-space-md">Tanggal Bayar</th>
                                <th class="py-3 px-space-md">Metode Bayar</th>
                                <th class="py-3 px-space-md text-right">Nominal</th>
                                <th class="py-3 px-space-md text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/15 font-body-md text-body-md">
                            @forelse($siswa ? $siswa->pembayarans : [] as $p)
                                <tr class="hover:bg-surface-container-low/50 transition-colors">
                                    <td class="py-3.5 px-space-md font-mono text-label-sm text-primary font-bold">
                                        {{ $p->kode_transaksi }}
                                    </td>
                                    <td class="py-3.5 px-space-md">
                                        <span class="font-label-lg text-label-lg text-on-surface block font-semibold">Iuran Minggu ke-{{ $p->minggu_ke }}</span>
                                        <span class="font-body-sm text-body-sm text-on-surface-variant">Bulan {{ $p->bulan }} {{ $p->tahun }}</span>
                                    </td>
                                    <td class="py-3.5 px-space-md text-on-surface">
                                        {{ \Carbon\Carbon::parse($p->tanggal_bayar)->translatedFormat('d M Y, H:i') }}
                                    </td>
                                    <td class="py-3.5 px-space-md">
                                        <span class="inline-flex items-center gap-1.5 text-on-surface font-label-md text-label-md">
                                            <span class="material-symbols-outlined text-[16px] text-primary">
                                                {{ $p->metode_pembayaran === 'qris' ? 'qr_code_2' : ($p->metode_pembayaran === 'transfer' ? 'account_balance' : 'payments') }}
                                            </span>
                                            <span class="capitalize">{{ $p->metode_pembayaran }}</span>
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-space-md text-right font-headline-sm text-headline-sm text-on-surface font-semibold">
                                        Rp {{ number_format($p->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3.5 px-space-md text-center">
                                        <button class="px-3 py-1.5 rounded-lg bg-primary-fixed/40 text-primary hover:bg-primary-fixed text-label-sm font-label-sm inline-flex items-center gap-1 transition-colors"
                                                onclick="showReceipt('{{ $p->kode_transaksi }}', 'Iuran Minggu {{ $p->minggu_ke }} ({{ $p->bulan }})', 'Rp {{ number_format($p->jumlah, 0, ',', '.') }}', '{{ \Carbon\Carbon::parse($p->tanggal_bayar)->translatedFormat('d F Y') }}', '{{ strtoupper($p->metode_pembayaran) }}')">
                                            <span class="material-symbols-outlined text-[16px]">receipt</span> Kuitansi
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-outline font-body-md">
                                        Belum ada data pembayaran untuk siswa ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pusat Bantuan & Kontak Bendahara -->
        <div class="space-y-space-md">
            <div>
                <div class="flex items-center gap-2 text-primary">
                    <span class="material-symbols-outlined text-[20px]">support_agent</span>
                    <span class="font-label-md text-label-md uppercase tracking-wider">Pusat Bantuan</span>
                </div>
                <h2 class="font-headline-lg text-headline-lg text-on-surface">Kontak Bendahara Kelas</h2>
            </div>
            
            <div class="rounded-2xl bg-surface-container-lowest p-space-lg shadow-sm border border-outline-variant/30 space-y-space-md">
                <div class="flex items-center gap-space-md">
                    <div class="relative shrink-0">
                        <div class="w-16 h-16 rounded-2xl bg-primary/10 text-primary flex items-center justify-center font-bold text-xl ring-2 ring-primary/20 shadow-sm shrink-0">
                            SP
                        </div>
                        <span class="absolute -bottom-1 -right-1 w-4 h-4 bg-secondary rounded-full border-2 border-white" title="Aktif di Jam Sekolah"></span>
                    </div>
                    <div>
                        <h4 class="font-headline-md text-headline-md text-on-surface font-semibold">Salsabila Putri</h4>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Bendahara 1 - XII MIPA 2</p>
                        <span class="inline-block mt-1 font-label-sm text-label-sm text-secondary bg-secondary-fixed/30 px-2 py-0.5 rounded font-medium">
                            Online Jam Sekolah
                        </span>
                    </div>
                </div>

                <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                    Ada pertanyaan seputar uang kas, rekonsiliasi transfer, atau butuh bantuan bukti setor? Jangan ragu hubungi bendahara secara langsung.
                </p>

                <div class="space-y-space-xs pt-space-xs">
                    <a class="w-full flex items-center justify-center gap-2.5 px-4 py-3 rounded-xl bg-secondary text-white font-label-lg text-label-lg hover:bg-secondary/90 transition-colors shadow-sm" href="https://wa.me/6281234567890" rel="noopener noreferrer" target="_blank">
                        <span class="material-symbols-outlined text-[20px]">chat</span> Chat WhatsApp: 0812-3456-7890
                    </a>
                    <button class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-surface-container-low hover:bg-surface-container-high text-on-surface font-label-md text-label-md transition-colors" onclick="window.confirmModal({ title: 'Nomor Rekening Resmi Kelas XII MIPA 2', message: 'Bank BRI: 1029-01-002931-50-2 a.n. Salsabila Putri (Bendahara 1). Simpan bukti transfer untuk verifikasi iuran kas.', type: 'info', confirmText: 'Salin No. Rekening', cancelText: 'Tutup', onConfirm: () => { navigator.clipboard.writeText('102901002931502'); window.showToast('Nomor Rekening BRI berhasil disalin!', 'success'); } })">
                        <span class="material-symbols-outlined text-[18px]">account_balance_wallet</span> Lihat Nomor Rekening Resmi Kelas
                    </button>
                </div>

                <div class="p-space-sm rounded-xl bg-surface-container-low/70 space-y-1">
                    <div class="flex items-center gap-1.5 text-on-surface font-label-sm text-label-sm font-semibold">
                        <span class="material-symbols-outlined text-[16px] text-tertiary">info</span> Catatan untuk Orang Tua / Wali:
                    </div>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">
                        Setiap akhir semester ganjil, rekapitulasi lengkap bertanda tangan Wali Kelas akan dibagikan dalam format buku laporan kas cetak.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Kuitansi Digital -->
    <div class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm hidden flex items-center justify-center p-4" id="receipt-modal">
        <div class="bg-surface-container-lowest rounded-2xl max-w-md w-full shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200">
            <div class="p-space-lg bg-primary text-on-primary flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[24px]">verified</span>
                    <div>
                        <h3 class="font-headline-sm text-headline-sm font-bold">Kuitansi Pembayaran Resmi</h3>
                        <p class="font-label-sm text-label-sm text-primary-fixed">Kas Kelas XII MIPA 2 - TA 2024/2025</p>
                    </div>
                </div>
                <button class="text-white/80 hover:text-white p-1 rounded-lg" onclick="closeReceipt()">
                    <span class="material-symbols-outlined text-[22px]">close</span>
                </button>
            </div>
            <div class="p-space-lg space-y-space-md">
                <div class="text-center py-2 border-b border-dashed border-outline-variant/50">
                    <span class="font-label-sm text-label-sm text-on-surface-variant">Nomor Kuitansi Digital:</span>
                    <div class="font-mono font-headline-sm text-primary font-bold" id="modal-receipt-id">KAS-2410-0001</div>
                </div>
                <div class="space-y-space-sm text-body-md">
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Diterima dari:</span>
                        <span class="font-semibold text-on-surface" id="modal-receipt-student">{{ $siswa ? $siswa->nama : '-' }} ({{ $siswa ? $siswa->nis : '-' }})</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Tujuan Iuran:</span>
                        <span class="font-semibold text-on-surface" id="modal-receipt-purpose">Iuran Kas Minggu 1</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Tanggal Transaksi:</span>
                        <span class="font-semibold text-on-surface" id="modal-receipt-date">24 Oktober 2024</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Metode Pembayaran:</span>
                        <span class="font-semibold text-on-surface" id="modal-receipt-channel">QRIS Mandiri</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-outline-variant/30">
                        <span class="font-bold text-on-surface">Jumlah Nominal:</span>
                        <span class="font-headline-md text-headline-md text-secondary font-bold" id="modal-receipt-amount">Rp 5.000</span>
                    </div>
                </div>
                <div class="p-3 bg-secondary-fixed/20 rounded-xl flex items-center gap-3">
                    <span class="material-symbols-outlined text-secondary text-[24px]">verified_user</span>
                    <div class="text-left font-body-sm text-body-sm text-on-surface">
                        Status: <strong>SAH & TERCATAT</strong> dalam buku kas resmi bendahara kelas.
                    </div>
                </div>
                <div class="flex gap-space-sm pt-2">
                    <button class="w-1/2 py-2.5 rounded-xl bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-md text-label-md transition-colors" onclick="closeReceipt()">
                        Tutup
                    </button>
                    <button class="w-1/2 py-2.5 rounded-xl bg-primary text-on-primary hover:bg-primary-container font-label-md text-label-md transition-colors shadow-sm flex items-center justify-center gap-1.5" onclick="window.print()">
                        <span class="material-symbols-outlined text-[16px]">print</span> Cetak Kuitansi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/portal.js') }}"></script>
@endpush
