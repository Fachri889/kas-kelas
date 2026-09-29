@extends('layouts.app')

@section('title', 'Dashboard Bendahara')

@section('content')
<div class="flex flex-col w-full gap-space-lg">
    <!-- 1. Header Salam & Quick Action -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 bg-surface-container-lowest p-5 sm:p-6 rounded-2xl shadow-xs border border-outline-variant/30">
        <div class="flex flex-col gap-1 min-w-0 flex-1">
            <div class="flex items-center gap-2 flex-wrap">
                <h1 class="font-headline-lg text-headline-lg text-on-surface font-bold">Selamat Datang, Salsabila!</h1>
            </div>
            <p class="font-body-md text-body-md text-on-surface-variant flex items-center gap-2">
                <span class="inline-block w-2 h-2 rounded-full bg-secondary shrink-0"></span>
                <span class="truncate sm:whitespace-normal">Sistem Keuangan Kas Kelas XII IPA 2 · Tahun Ajaran 2024/2025</span>
            </p>
        </div>
        <div class="flex flex-row items-center gap-2.5 sm:gap-3 shrink-0 flex-nowrap overflow-x-auto pt-1 lg:pt-0">
            <a href="{{ route('pembayaran.index') }}" class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2.5 rounded-xl bg-primary-container text-on-primary font-label-lg text-label-lg shadow-sm hover:opacity-90 transition-all font-semibold whitespace-nowrap">
                <span class="material-symbols-outlined text-[19px]">add_circle</span>
                <span>Catat Pembayaran Baru</span>
            </a>
            @if(Route::has('pemasukan.index'))
            <a href="{{ route('pemasukan.index') }}" class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2.5 rounded-xl bg-surface-container text-on-surface font-label-lg text-label-lg hover:bg-surface-container-high transition-colors font-medium whitespace-nowrap">
                <span class="material-symbols-outlined text-[19px]">account_balance</span>
                <span>Buku Pemasukan</span>
            </a>
            @endif
            <a href="{{ route('pengeluaran.index') }}" class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2.5 rounded-xl bg-surface-container text-on-surface font-label-lg text-label-lg hover:bg-surface-container-high transition-colors font-medium whitespace-nowrap">
                <span class="material-symbols-outlined text-[19px]">receipt_long</span>
                <span>Tambah Pengeluaran</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
        <!-- Saldo Kas -->
        <div class="bg-surface-container-lowest p-space-lg rounded-xl shadow-xs border border-outline-variant/30 flex flex-col justify-between relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-primary/5 rounded-bl-full pointer-events-none transition-transform group-hover:scale-110"></div>
            <div class="flex items-center justify-between mb-space-sm">
                <span class="font-label-md text-label-md text-on-surface-variant font-medium">Saldo Kas Saat Ini</span>
                <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">account_balance_wallet</span>
                </div>
            </div>
            <div>
                <span class="font-headline-lg text-headline-lg text-on-surface font-bold tabular-nums">
                    Rp {{ number_format($saldoKas, 0, ',', '.') }}
                </span>
                <div class="flex items-center gap-1.5 mt-2">
                    <span class="inline-flex items-center text-secondary font-label-sm text-label-sm font-semibold">
                        <span class="material-symbols-outlined text-[16px]">trending_up</span> Kas Siap Pakai
                    </span>
                </div>
            </div>
        </div>

        <!-- Total Pemasukan -->
        <div class="bg-surface-container-lowest p-space-lg rounded-xl shadow-xs border border-outline-variant/30 flex flex-col justify-between relative overflow-hidden group">
            <div class="flex items-center justify-between mb-space-sm">
                <span class="font-label-md text-label-md text-on-surface-variant font-medium">Total Pemasukan</span>
                <div class="w-10 h-10 rounded-xl bg-secondary-fixed/40 text-secondary flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">arrow_downward</span>
                </div>
            </div>
            <div>
                <span class="font-headline-lg text-headline-lg text-on-surface font-bold tabular-nums">
                    Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                </span>
                <div class="flex items-center gap-1.5 mt-2">
                    <span class="font-body-sm text-[11px] text-on-surface-variant">Bulan Oktober 2024</span>
                </div>
            </div>
        </div>

        <!-- Total Pengeluaran -->
        <div class="bg-surface-container-lowest p-space-lg rounded-xl shadow-xs border border-outline-variant/30 flex flex-col justify-between relative overflow-hidden group">
            <div class="flex items-center justify-between mb-space-sm">
                <span class="font-label-md text-label-md text-on-surface-variant font-medium">Total Pengeluaran</span>
                <div class="w-10 h-10 rounded-xl bg-error-container/40 text-error flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">arrow_upward</span>
                </div>
            </div>
            <div>
                <span class="font-headline-lg text-headline-lg text-on-surface font-bold tabular-nums">
                    Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                </span>
                <div class="flex items-center gap-1.5 mt-2">
                    <span class="font-body-sm text-[11px] text-on-surface-variant">4 transaksi terverifikasi</span>
                </div>
            </div>
        </div>

        <!-- Status Iuran Siswa -->
        <div class="bg-surface-container-lowest p-space-lg rounded-xl shadow-xs border border-outline-variant/30 flex flex-col justify-between relative overflow-hidden group">
            <div class="flex items-center justify-between mb-space-sm">
                <span class="font-label-md text-label-md text-on-surface-variant font-medium">Kepatuhan Siswa</span>
                <div class="w-10 h-10 rounded-xl bg-primary-fixed text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">groups</span>
                </div>
            </div>
            <div>
                <div class="flex items-baseline gap-2">
                    <span class="font-headline-lg text-headline-lg text-on-surface font-bold tabular-nums">{{ $persenLunas }}%</span>
                    <span class="font-body-sm text-body-sm text-on-surface-variant">({{ $siswaLunas }}/{{ $totalSiswa }} Siswa)</span>
                </div>
                <!-- Progress Bar -->
                <div class="w-full bg-surface-container h-2 rounded-full mt-3 overflow-hidden">
                    <div class="bg-secondary h-full rounded-full transition-all duration-500" style="width: {{ $persenLunas }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Arus Kas Terakhir & Daftar Menunggak -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-space-lg">
        <!-- Kolom Kiri: Riwayat Transaksi Terbaru (2 Kolom) -->
        <div class="lg:col-span-2 bg-surface-container-lowest p-space-lg rounded-xl shadow-xs border border-outline-variant/30 flex flex-col justify-between">
            <div class="flex items-center justify-between pb-space-md border-b border-outline-variant/30">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[22px]">history</span>
                    <h2 class="font-headline-sm text-headline-sm text-on-surface font-bold">Aktivitas Transaksi Terbaru</h2>
                </div>
                <a href="{{ route('pemasukan.index') }}" class="font-label-sm text-label-sm text-primary hover:underline">Lihat Semua</a>
            </div>
            
            <div class="divide-y divide-outline-variant/20">
                @foreach($recentIncomes as $inc)
                    <div class="py-3.5 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 rounded-xl bg-secondary-fixed/30 text-secondary flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[20px]">south_west</span>
                            </div>
                            <div class="flex flex-col min-w-0">
                                <span class="font-label-lg text-label-lg text-on-surface truncate">{{ $inc['judul'] }}</span>
                                <span class="font-body-sm text-body-sm text-on-surface-variant">{{ $inc['tanggal'] }} · {{ $inc['kategori'] }}</span>
                            </div>
                        </div>
                        <span class="font-label-lg text-label-lg text-secondary font-bold tabular-nums shrink-0">
                            +Rp {{ number_format($inc['nominal'], 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach

                @foreach($recentExpenses as $exp)
                    <div class="py-3.5 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 rounded-xl bg-error-container/40 text-error flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[20px]">north_east</span>
                            </div>
                            <div class="flex flex-col min-w-0">
                                <span class="font-label-lg text-label-lg text-on-surface truncate">{{ $exp['judul'] }}</span>
                                <span class="font-body-sm text-body-sm text-on-surface-variant">{{ $exp['tanggal'] }} · {{ $exp['pj'] }}</span>
                            </div>
                        </div>
                        <span class="font-label-lg text-label-lg text-error font-bold tabular-nums shrink-0">
                            -Rp {{ number_format($exp['nominal'], 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach
            </div>

            <div class="pt-3 border-t border-outline-variant/20 flex justify-between items-center text-body-sm text-on-surface-variant">
                <span>Total tercatat di sistem: {{ count($recentIncomes) + count($recentExpenses) }} mutasi terkini</span>
                <a href="{{ route('laporan.index') }}" class="font-label-sm text-primary hover:underline flex items-center gap-1 font-semibold">
                    <span>Laporan Lengkap</span>
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </div>
        </div>

        <!-- Kolom Kanan: Siswa Menunggak Kas (1 Kolom) -->
        <div class="bg-surface-container-lowest p-space-lg rounded-xl shadow-xs border border-outline-variant/30 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-space-md border-b border-outline-variant/30">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-600 text-[22px]">pending_actions</span>
                        <h2 class="font-headline-sm text-headline-sm text-on-surface font-bold">Tunggakan Kas Siswa</h2>
                    </div>
                    <span class="font-label-sm text-[11px] px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 font-bold">
                        {{ $siswaMenunggak->count() }} Siswa
                    </span>
                </div>

                <div class="divide-y divide-outline-variant/20 mt-1">
                    @forelse($siswaMenunggak as $siswa)
                        <div class="py-3 flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-800 flex items-center justify-center font-bold text-xs shrink-0">
                                    {{ $siswa->initials }}
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <span class="font-label-md text-label-md text-on-surface truncate">{{ $siswa->nama }}</span>
                                    <span class="font-body-sm text-[11px] text-on-surface-variant">Terbayar: Rp {{ number_format($siswa->total_terbayar, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5 shrink-0">
                                <span class="font-label-sm text-label-sm text-error font-bold tabular-nums">
                                    -Rp {{ number_format($siswa->sisa_kas, 0, ',', '.') }}
                                </span>
                                @if($siswa->no_hp)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siswa->no_hp) }}?text=Halo%20{{ urlencode($siswa->nama) }},%20mengingatkan%20iuran%20kas%20kelas%20kurang%20Rp%20{{ number_format($siswa->sisa_kas, 0, ',', '.') }}." target="_blank" class="p-1 text-secondary hover:bg-secondary-container/40 rounded transition-colors" title="Kirim WA Pengingat">
                                        <span class="material-symbols-outlined text-[18px]">chat</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="py-8 text-center text-on-surface-variant">
                            <span class="material-symbols-outlined text-[32px] text-secondary mb-1">celebration</span>
                            <p class="font-body-md text-body-md">Luar biasa! Semua siswa telah lunas kas.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="pt-4 border-t border-outline-variant/20 mt-4">
                <a href="{{ route('siswa.index', ['status' => 'belum_lunas']) }}" class="w-full flex items-center justify-center gap-2 py-2.5 px-space-md rounded-lg bg-surface-container text-on-surface font-label-lg text-label-lg hover:bg-surface-container-high transition-colors">
                    <span class="material-symbols-outlined text-primary text-[18px]">group</span>
                    <span>Kelola Semua Data Siswa</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
