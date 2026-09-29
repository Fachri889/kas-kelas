@extends('layouts.siswa')

@section('title', 'Dashboard Siswa - Kas Kelas')

@section('content')
<div class="flex flex-col w-full gap-6 max-w-7xl mx-auto">
    <!-- C. Hero Welcome Banner (Toned Down Elegant Gradient Card) -->
    <!-- C. Hero Welcome Banner (Matching Image 3) -->
    <div class="relative w-full overflow-hidden rounded-2xl text-white p-6 sm:p-8 md:p-10 shadow-xl border border-slate-700/60 hero-gradient-navy">
        
        <!-- Decorative subtle background blurs -->
        <div class="absolute -right-16 -top-24 w-80 h-80 rounded-full bg-slate-700/20 blur-3xl pointer-events-none"></div>
        <div class="absolute right-1/4 -bottom-20 w-60 h-60 rounded-full bg-blue-900/20 blur-2xl pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8">
            <!-- Left Section -->
            <div class="space-y-4 max-w-2xl">
                <!-- Uppercase Pill Badge -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-white/90 shadow-2xs">
                    <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                    <span class="text-[11px] font-bold tracking-wider uppercase">PORTAL TRANSPARANSI PUBLIK SISWA & WALI MURID</span>
                </div>
                
                <!-- Large Greeting Heading -->
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-white tracking-tight leading-tight">
                    Halo, {{ $siswa ? $siswa->nama : 'Ahmad Fauzi' }}!
                </h2>
                
                <!-- Semi-transparent Description -->
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed font-normal">
                    Selamat datang di portal transparansi keuangan kelas <strong>{{ $siswa ? $siswa->kelas : 'XII IPA 2' }}</strong>. Seluruh mutasi dana kas tercatat akuntabel, terbuka, dan dapat dipantau oleh seluruh siswa dan wali murid.
                </p>
                
                <!-- Badges -->
                <div class="flex flex-wrap items-center gap-2.5 pt-1">
                    @php
                        $isLunas = $siswa && $siswa->status === 'lunas';
                    @endphp
                    @if($isLunas)
                        <div class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-[#DCFCE7] text-[#15803D] font-bold text-xs shadow-xs">
                            <span class="material-symbols-outlined text-[17px]">verified</span>
                            <span>Status Kas: LUNAS SEMUA MINGGU</span>
                        </div>
                    @else
                        <div class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-[#FEE2E2] text-[#DC2626] font-bold text-xs shadow-xs">
                            <span class="material-symbols-outlined text-[17px]">pending</span>
                            <span>Status Kas: BELUM LUNAS</span>
                        </div>
                    @endif

                    <div class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white font-medium text-xs">
                        <span class="material-symbols-outlined text-[16px]">account_balance_wallet</span>
                        <span>
                            {{ ($siswa && $siswa->sisa_kas <= 0) ? 'Nol Tunggakan (Rp 0)' : 'Sisa Tunggakan: Rp ' . number_format($siswa ? $siswa->sisa_kas : 0, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Right Section -->
            <div class="flex flex-col sm:flex-row lg:flex-col gap-3 shrink-0 lg:w-72">
                <!-- Student Selector Dropdown with Image 3 Styling -->
                <div class="bg-[#212E42]/80 backdrop-blur-md rounded-2xl p-3.5 border border-[#33445C] shadow-sm flex flex-col gap-1.5">
                    <label for="pilih-siswa" class="block text-white text-[11px] font-bold uppercase tracking-wider">
                        PILIH DATA SISWA:
                    </label>
                    <select id="pilih-siswa" 
                            class="w-full bg-white text-slate-800 font-semibold text-xs sm:text-sm py-2 px-3 rounded-xl border-0 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all cursor-pointer" 
                            onchange="window.location.href='{{ route('siswa.dashboard') }}?nis=' + this.value + '#rincian-siswa'">
                        @foreach($allStudents as $st)
                            <option value="{{ $st->nis }}" {{ ($siswa && $siswa->nis === $st->nis) ? 'selected' : '' }}>
                                {{ $st->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Primary Button: Solid White Button with Dark Blue Text -->
                <a href="{{ route('siswa.pembayaran.index') }}" 
                   class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-white text-[#1E40AF] hover:bg-slate-100 font-bold text-sm shadow-md hover:shadow-lg active:scale-95 transition-all duration-200">
                    <span class="material-symbols-outlined text-[19px] text-[#1E40AF]">receipt_long</span>
                    <span>Lihat Riwayat & Kuitansi</span>
                </a>

                <!-- Secondary Button: Translucent Dark Navy Outline Button -->
                <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Bendahara, saya ingin konfirmasi kas kelas untuk siswa ' . ($siswa ? $siswa->nama : '')) }}" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-[#233147] hover:bg-[#2B3C56] text-white border border-[#3A4D6B] font-semibold text-xs sm:text-sm transition-all duration-200">
                    <span class="material-symbols-outlined text-[18px]">chat</span>
                    <span>Konfirmasi ke Bendahara</span>
                </a>
            </div>
        </div>
    </div>

    <!-- D. Balance Statistics Grid (3 Columns) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- Card 1 (Net Balance) -->
        <div class="bg-white rounded-2xl p-6 shadow-[0_4px_20px_-2px_rgba(0,0,0,0.05)] border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow">
            <div>
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                            Saldo Kas Bersih Saat Ini
                        </span>
                        <div class="text-2xl sm:text-3xl font-extrabold text-[#1E40AF] mt-1 tracking-tight">
                            Rp {{ number_format($saldoKas, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-[#DBEAFE] text-[#1E40AF] flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[26px]">account_balance</span>
                    </div>
                </div>
            </div>
            <!-- Green checkmark footer -->
            <div class="mt-5 pt-3 border-t border-slate-100 flex items-center gap-2.5 text-[#15803D] bg-[#F0FDF4] px-3.5 py-2.5 rounded-xl border border-emerald-100/70">
                <span class="material-symbols-outlined text-[19px] shrink-0">check_circle</span>
                <p class="text-xs font-medium leading-snug">
                    Telah diverifikasi silang oleh <strong>Wali Kelas & Bendahara</strong>
                </p>
            </div>
        </div>

        <!-- Card 2 (Total Income) -->
        <div class="bg-white rounded-2xl p-6 shadow-[0_4px_20px_-2px_rgba(0,0,0,0.05)] border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow">
            <div>
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                            Total Pemasukan Kas
                        </span>
                        <div class="text-2xl sm:text-3xl font-extrabold text-[#15803D] mt-1 tracking-tight">
                            + Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-[#DCFCE7] text-[#15803D] flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[26px]">trending_up</span>
                    </div>
                </div>
            </div>
            <!-- Trend Badge, Participation Stats & Slim Progress Bar -->
            <div class="mt-5 pt-3 border-t border-slate-100">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-xs text-slate-500 font-medium">Partisipasi Siswa Lunas</span>
                    <span class="inline-flex items-center gap-1 text-xs font-bold text-[#15803D] bg-[#DCFCE7] px-2 py-0.5 rounded-md">
                        {{ $siswaLunasCount }} dari {{ $totalSiswa }} Siswa ({{ $partisipasiPersen }}%)
                    </span>
                </div>
                <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                    <div class="h-full bg-[#15803D] rounded-full transition-all duration-500" style="width: {{ min(100, $partisipasiPersen) }}%"></div>
                </div>
            </div>
        </div>

        <!-- Card 3 (Total Expenses) -->
        <div class="bg-white rounded-2xl p-6 shadow-[0_4px_20px_-2px_rgba(0,0,0,0.05)] border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow">
            <div>
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                            Total Belanja & Pengeluaran
                        </span>
                        <div class="text-2xl sm:text-3xl font-extrabold text-[#DC2626] mt-1 tracking-tight">
                            - Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-[#FEE2E2] text-[#DC2626] flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[26px]">shopping_cart</span>
                    </div>
                </div>
            </div>
            <!-- Expense Summary & Soft-pink Badge -->
            <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-500 font-medium">
                    {{ $pengeluarans->count() }} Transaksi Kebutuhan Kelas
                </span>
                <span class="inline-flex items-center gap-1 text-xs font-bold text-[#DC2626] bg-[#FEE2E2] px-2.5 py-1 rounded-lg border border-red-100">
                    <span class="material-symbols-outlined text-[14px]">receipt</span>
                    Nota Terlampir
                </span>
            </div>
        </div>
    </div>

    <!-- E. Tabel Transparansi Status Kas & Tunggakan Seluruh Siswa -->
    <div class="bg-white rounded-2xl shadow-[0_4px_20px_-2px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden" id="daftar-tunggakan-siswa">
        <!-- Header -->
        <div class="p-6 sm:px-8 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#2563EB] text-[24px]">group</span>
                    <h3 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">
                        Transparansi Status Iuran & Tunggakan Seluruh Siswa
                    </h3>
                </div>
                <p class="text-xs text-slate-500 mt-1">
                    Daftar rekapitulasi status pembayaran iuran kelas <strong>{{ $siswa ? $siswa->kelas : 'XII MIPA 2' }}</strong>. Menampilkan siswa yang telah lunas dan siswa yang memiliki tunggakan.
                </p>
            </div>

            <!-- Arrears Summary Mini Stats -->
            <div class="flex flex-wrap items-center gap-2">
                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200/80 text-xs font-semibold">
                    <span class="material-symbols-outlined text-[16px]">check_circle</span>
                    <span>Lunas: <strong>{{ $siswaLunasCount }} Siswa</strong></span>
                </div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-red-50 text-red-700 border border-red-200/80 text-xs font-semibold">
                    <span class="material-symbols-outlined text-[16px]">warning</span>
                    <span>Menunggak: <strong>{{ $siswaNunggakCount }} Siswa</strong></span>
                </div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700 border border-slate-200 text-xs font-semibold">
                    <span>Total Tunggakan: <strong class="text-red-600 font-mono">Rp {{ number_format($totalTunggakanKelas, 0, ',', '.') }}</strong></span>
                </div>
            </div>
        </div>

        <!-- Filter Controls & Search -->
        <div class="p-4 sm:px-8 bg-slate-50/70 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-2 overflow-x-auto">
                <button type="button" 
                        class="filter-btn px-3 py-1.5 rounded-lg text-xs font-bold transition-all bg-blue-600 text-white shadow-2xs" 
                        data-filter="all" 
                        onclick="filterStudents('all', this)">
                    Semua ({{ $totalSiswa }})
                </button>
                <button type="button" 
                        class="filter-btn px-3 py-1.5 rounded-lg text-xs font-semibold transition-all bg-white text-slate-600 hover:text-slate-900 border border-slate-200" 
                        data-filter="nunggak" 
                        onclick="filterStudents('nunggak', this)">
                    Punya Tunggakan ({{ $siswaNunggakCount }})
                </button>
                <button type="button" 
                        class="filter-btn px-3 py-1.5 rounded-lg text-xs font-semibold transition-all bg-white text-slate-600 hover:text-slate-900 border border-slate-200" 
                        data-filter="lunas" 
                        onclick="filterStudents('lunas', this)">
                    Lunas ({{ $siswaLunasCount }})
                </button>
            </div>

            <!-- Search Input -->
            <div class="relative w-full sm:w-64">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[18px] pointer-events-none">search</span>
                <input type="text" 
                       id="search-siswa-input" 
                       class="w-full pl-9 pr-3 py-1.5 rounded-xl bg-white border border-slate-200 text-xs text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all shadow-2xs" 
                       placeholder="Cari nama siswa..." 
                       oninput="searchStudents(this.value)"/>
            </div>
        </div>

        <!-- Students Table -->
        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-left border-collapse" id="table-students-list">
                <thead>
                    <tr class="bg-white border-b border-slate-200/80 text-slate-500 font-bold text-[11px] uppercase tracking-wider">
                        <th class="py-3.5 px-6 w-12 text-center">NO</th>
                        <th class="py-3.5 px-6">NAMA SISWA</th>
                        <th class="py-3.5 px-6">WALI MURID</th>
                        <th class="py-3.5 px-6 text-right">TARGET KAS</th>
                        <th class="py-3.5 px-6 text-right">TERBAYAR</th>
                        <th class="py-3.5 px-6 text-right">SISA TUNGGAKAN</th>
                        <th class="py-3.5 px-6 text-center">STATUS KAS</th>
                        <th class="py-3.5 px-6 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($allStudents as $index => $st)
                        @php
                            $isRowLunas = $st->status === 'lunas';
                            $isSelected = $siswa && $siswa->id === $st->id;
                        @endphp
                        <tr class="student-row hover:bg-slate-50/80 transition-colors {{ $isSelected ? 'bg-blue-50/40' : '' }}" 
                            data-status="{{ $isRowLunas ? 'lunas' : 'nunggak' }}" 
                            data-name="{{ strtolower($st->nama) }}" 
                            data-nis="{{ $st->nis }}">
                            <!-- No -->
                            <td class="py-3.5 px-6 text-center text-xs font-semibold text-slate-400">
                                {{ $index + 1 }}
                            </td>

                            <!-- Siswa -->
                            <td class="py-3.5 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full {{ $isRowLunas ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }} flex items-center justify-center font-bold text-xs uppercase shrink-0">
                                        {{ $st->initials }}
                                    </div>
                                    <div>
                                        <a href="{{ route('siswa.dashboard', ['nis' => $st->nis]) }}#rincian-siswa" 
                                           class="font-bold text-slate-900 hover:text-blue-600 transition-colors inline-flex items-center gap-1.5">
                                            <span>{{ $st->nama }}</span>
                                            @if($isSelected)
                                                <span class="px-1.5 py-0.5 rounded text-[10px] font-semibold bg-blue-100 text-blue-700">Dipilih</span>
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </td>

                            <!-- Wali Murid -->
                            <td class="py-3.5 px-6 text-xs text-slate-600 font-medium">
                                {{ $st->nama_wali ?: '-' }}
                            </td>

                            <!-- Target Kas -->
                            <td class="py-3.5 px-6 text-right font-medium text-xs text-slate-700 tabular-nums">
                                Rp {{ number_format($st->target_kas, 0, ',', '.') }}
                            </td>

                            <!-- Terbayar -->
                            <td class="py-3.5 px-6 text-right font-bold text-xs text-emerald-700 tabular-nums">
                                Rp {{ number_format($st->total_terbayar, 0, ',', '.') }}
                            </td>

                            <!-- Sisa Tunggakan -->
                            <td class="py-3.5 px-6 text-right whitespace-nowrap">
                                @if($st->sisa_kas > 0)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold text-[#DC2626] bg-[#FEE2E2] border border-red-200/80 whitespace-nowrap tabular-nums">
                                        <span class="material-symbols-outlined text-[15px]">warning</span>
                                        <span>Rp {{ number_format($st->sisa_kas, 0, ',', '.') }}</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold text-[#15803D] bg-[#DCFCE7] border border-emerald-200/80 whitespace-nowrap tabular-nums">
                                        <span class="material-symbols-outlined text-[15px]">check_circle</span>
                                        <span>Rp 0 (Lunas)</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Status Kas -->
                            <td class="py-3.5 px-6 text-center whitespace-nowrap">
                                @if($isRowLunas)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-[#DCFCE7] text-[#15803D] border border-emerald-200/70 whitespace-nowrap">
                                        <span class="material-symbols-outlined text-[14px]">verified</span>
                                        <span>LUNAS</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-[#FEE2E2] text-[#DC2626] border border-red-200/70 whitespace-nowrap">
                                        <span class="material-symbols-outlined text-[14px]">pending</span>
                                        <span>BELUM LUNAS</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="py-3.5 px-6 text-center whitespace-nowrap">
                                <a href="{{ route('siswa.dashboard', ['nis' => $st->nis]) }}#rincian-siswa" 
                                   class="inline-flex items-center justify-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-bold {{ $isSelected ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }} transition-colors whitespace-nowrap">
                                    <span class="material-symbols-outlined text-[16px]">visibility</span>
                                    <span>Pilih Siswa</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-10 text-center text-slate-400 text-sm">
                                Tidak ada data siswa ditemukan.
                            </td>
                        </tr>
                    @endforelse
                    <tr id="empty-search-row" class="hidden">
                        <td colspan="8" class="py-8 text-center text-slate-400 text-sm">
                            Tidak ditemukan siswa dengan kata kunci pencarian tersebut.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Status Iuran Pribadi Per Minggu -->
    <div class="bg-white rounded-2xl p-6 sm:p-7 shadow-[0_4px_20px_-2px_rgba(0,0,0,0.05)] border border-slate-100" id="rincian-siswa">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
            <div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">
                    Status Iuran Kas Pribadi ({{ $siswa ? $siswa->nama : 'Siswa' }})
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Target kas: <strong>Rp {{ number_format($siswa ? $siswa->target_kas : 80000, 0, ',', '.') }}</strong> per bulan (Rp 20.000 / minggu)
                </p>
            </div>
            <div class="flex items-center gap-2.5">
                <span class="text-xs text-slate-600 bg-slate-50 border border-slate-200/80 px-3 py-1.5 rounded-xl font-medium">
                    Total Terbayar: <strong class="text-[#15803D]">Rp {{ number_format($siswa ? $siswa->total_terbayar : 0, 0, ',', '.') }}</strong>
                </span>
            </div>
        </div>

        @php
            $mingguList = [
                ['minggu' => 1, 'label' => 'Minggu ke-1', 'nominal' => 20000],
                ['minggu' => 2, 'label' => 'Minggu ke-2', 'nominal' => 20000],
                ['minggu' => 3, 'label' => 'Minggu ke-3', 'nominal' => 20000],
                ['minggu' => 4, 'label' => 'Minggu ke-4', 'nominal' => 20000],
            ];
            $pembayaransByMinggu = $siswa ? $siswa->pembayarans->keyBy('minggu_ke') : collect();
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($mingguList as $m)
                @php
                    $pmb = $pembayaransByMinggu->get($m['minggu']);
                    $isLunasMinggu = $pmb && $pmb->status === 'lunas';
                @endphp
                <div class="relative rounded-xl p-4.5 border {{ $isLunasMinggu ? 'border-emerald-200/80 bg-emerald-50/20' : 'border-slate-200 bg-slate-50/50' }} flex flex-col justify-between transition-all">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold uppercase tracking-wider {{ $isLunasMinggu ? 'text-[#15803D]' : 'text-slate-500' }}">
                                {{ $m['label'] }}
                            </span>
                            @if($isLunasMinggu)
                                <span class="material-symbols-outlined text-[18px] text-[#15803D]">check_circle</span>
                            @else
                                <span class="material-symbols-outlined text-[18px] text-slate-400">schedule</span>
                            @endif
                        </div>
                        <h4 class="text-sm font-bold text-slate-800 mt-1">Iuran Wajib</h4>
                        <div class="text-base font-extrabold text-slate-900 mt-0.5">
                            Rp {{ number_format($m['nominal'], 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t {{ $isLunasMinggu ? 'border-emerald-200/60' : 'border-slate-200' }}">
                        @if($isLunasMinggu)
                            <div class="inline-flex items-center gap-1.5 w-full justify-center py-1 rounded-lg bg-[#DCFCE7] text-[#15803D] text-[11px] font-bold">
                                <span>Lunas</span>
                                <span class="text-emerald-700 font-normal">({{ \Carbon\Carbon::parse($pmb->tanggal_bayar)->translatedFormat('d M') }})</span>
                            </div>
                        @else
                            <div class="inline-flex items-center gap-1.5 w-full justify-center py-1 rounded-lg bg-[#FEE2E2] text-[#DC2626] text-[11px] font-bold">
                                <span>Belum Dibayar</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- E. Payment History & Receipt Data Table -->
    <div class="bg-white rounded-2xl shadow-[0_4px_20px_-2px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden">
        <!-- Table Card Header -->
        <div class="p-6 sm:px-8 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#2563EB] text-[22px]">receipt_long</span>
                    Riwayat Pembayaran & Kuitansi Siswa
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Data kuitansi pembayaran resmi yang telah terverifikasi oleh Bendahara Kelas
                </p>
            </div>
            <a href="{{ route('siswa.pembayaran.index') }}" class="text-xs font-semibold text-[#2563EB] hover:text-[#1D4ED8] flex items-center gap-1">
                <span>Buka Halaman Lengkap</span>
                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
            </a>
        </div>

        <!-- Table Responsive Container -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F8FAFC] border-b border-slate-200/80 text-slate-500 font-bold text-[11px] uppercase tracking-wider">
                        <th class="py-3.5 px-6">NO. TRANSAKSI</th>
                        <th class="py-3.5 px-6">KETERANGAN</th>
                        <th class="py-3.5 px-6">TANGGAL BAYAR</th>
                        <th class="py-3.5 px-6">METODE BAYAR</th>
                        <th class="py-3.5 px-6 text-right">NOMINAL</th>
                        <th class="py-3.5 px-6 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @php
                        $userPembayarans = $siswa ? $siswa->pembayarans : collect();
                    @endphp
                    @forelse($userPembayarans as $p)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- Transaction ID: Monospace/bold blue link style -->
                            <td class="py-4 px-6">
                                <span class="font-mono text-xs font-bold text-[#2563EB] bg-blue-50/80 hover:bg-blue-100 px-2.5 py-1 rounded-md border border-blue-100/80 cursor-pointer inline-block"
                                      onclick="showReceipt('{{ $p->kode_transaksi }}', 'Iuran Minggu ke-{{ $p->minggu_ke }} (Bulan {{ $p->bulan }})', 'Rp {{ number_format($p->nominal, 0, ',', '.') }}', '{{ \Carbon\Carbon::parse($p->tanggal_bayar)->translatedFormat('d F Y, H:i') }} WIB', '{{ strtoupper($p->metode_pembayaran) }}')">
                                    {{ $p->kode_transaksi }}
                                </span>
                            </td>

                            <!-- Description: Bold title + muted secondary line -->
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900 leading-tight">
                                    Iuran Minggu ke-{{ $p->minggu_ke }}
                                </div>
                                <div class="text-xs text-slate-500 mt-0.5">
                                    Periode: Bulan {{ $p->bulan }} {{ $p->tahun }}
                                </div>
                            </td>

                            <!-- Date & Time Format -->
                            <td class="py-4 px-6 text-slate-700 font-medium text-xs sm:text-sm">
                                {{ \Carbon\Carbon::parse($p->tanggal_bayar)->translatedFormat('d M Y, H:i') }} WIB
                            </td>

                            <!-- Payment Method Badge with Icon -->
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700">
                                    <span class="material-symbols-outlined text-[16px] text-blue-600">
                                        {{ $p->metode_pembayaran === 'qris' ? 'qr_code_2' : ($p->metode_pembayaran === 'transfer' ? 'account_balance' : 'payments') }}
                                    </span>
                                    <span>{{ strtoupper($p->metode_pembayaran) }}</span>
                                </span>
                            </td>

                            <!-- Nominal: Bold Structured Currency Formatting -->
                            <td class="py-4 px-6 text-right font-extrabold text-slate-900">
                                Rp {{ number_format($p->nominal, 0, ',', '.') }}
                            </td>

                            <!-- Action Column: Light-blue Tinted Outline Button with Document Icon -->
                            <td class="py-4 px-6 text-center">
                                <button type="button" 
                                        class="px-3.5 py-1.5 rounded-lg border border-blue-200 bg-blue-50/60 hover:bg-blue-100/70 text-[#1E40AF] text-xs font-bold inline-flex items-center gap-1.5 transition-colors shadow-2xs"
                                        onclick="showReceipt('{{ $p->kode_transaksi }}', 'Iuran Minggu ke-{{ $p->minggu_ke }} (Bulan {{ $p->bulan }})', 'Rp {{ number_format($p->nominal, 0, ',', '.') }}', '{{ \Carbon\Carbon::parse($p->tanggal_bayar)->translatedFormat('d F Y, H:i') }} WIB', '{{ strtoupper($p->metode_pembayaran) }}')">
                                    <span class="material-symbols-outlined text-[16px]">description</span>
                                    <span>Kuitansi</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400 text-sm">
                                <span class="material-symbols-outlined text-4xl text-slate-300 block mb-1">receipt</span>
                                Belum ada riwayat pembayaran kas tercatat untuk siswa ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Kuitansi Digital -->
<div id="receipt-modal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200 border border-slate-100">
        <!-- Modal Header -->
        <div class="p-6 text-white flex items-center justify-between hero-gradient-navy">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-[24px]">verified</span>
                </div>
                <div>
                    <h4 class="text-base font-bold leading-tight">Kuitansi Pembayaran Kas</h4>
                    <p class="text-xs text-blue-100 mt-0.5">Kas Kelas XII MIPA 2 - Resmi</p>
                </div>
            </div>
            <button type="button" class="text-white/80 hover:text-white p-1 rounded-lg transition-colors" onclick="closeReceipt()">
                <span class="material-symbols-outlined text-[22px]">close</span>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6 space-y-4">
            <!-- Receipt Number -->
            <div class="text-center py-2.5 border-b border-dashed border-slate-200 bg-slate-50/60 rounded-xl">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Nomor Kuitansi Digital</span>
                <div class="font-mono text-base font-extrabold text-[#2563EB] mt-0.5" id="modal-receipt-id">TRX-0000</div>
            </div>

            <!-- Details List -->
            <div class="space-y-2.5 text-xs sm:text-sm">
                <div class="flex justify-between items-center py-1 border-b border-slate-50">
                    <span class="text-slate-500">Nama Siswa:</span>
                    <span class="font-bold text-slate-900">{{ $siswa ? $siswa->nama : 'Ahmad Fauzi' }}</span>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-slate-50">
                    <span class="text-slate-500">Keterangan:</span>
                    <span class="font-bold text-slate-900" id="modal-receipt-purpose">Iuran Kas Minggu 1</span>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-slate-50">
                    <span class="text-slate-500">Tanggal Bayar:</span>
                    <span class="font-bold text-slate-900" id="modal-receipt-date">24 Oktober 2024</span>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-slate-50">
                    <span class="text-slate-500">Metode Bayar:</span>
                    <span class="font-bold text-slate-900" id="modal-receipt-channel">QRIS</span>
                </div>
                <div class="flex justify-between items-center pt-2">
                    <span class="text-sm font-bold text-slate-700">Nominal:</span>
                    <span class="text-xl font-extrabold text-[#15803D]" id="modal-receipt-amount">Rp 20.000</span>
                </div>
            </div>

            <!-- Verification Stamp Badge -->
            <div class="p-3 bg-[#DCFCE7]/60 border border-emerald-200/60 rounded-xl flex items-center gap-2.5">
                <span class="material-symbols-outlined text-[#15803D] text-[22px]">verified_user</span>
                <div class="text-xs text-[#15803D] leading-snug">
                    Status: <strong>SAH & TERCATAT</strong> dalam buku besar kas kelas.
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-3 pt-2">
                <button type="button" 
                        class="w-1/2 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs sm:text-sm transition-colors" 
                        onclick="closeReceipt()">
                    Tutup
                </button>
                <button type="button" 
                        class="w-1/2 py-2.5 rounded-xl bg-[#2563EB] hover:bg-[#1D4ED8] text-white font-bold text-xs sm:text-sm transition-colors shadow-sm flex items-center justify-center gap-1.5" 
                        onclick="window.print()">
                    <span class="material-symbols-outlined text-[17px]">print</span>
                    <span>Cetak</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showReceipt(id, purpose, amount, date, channel) {
    const modal = document.getElementById('receipt-modal');
    if (!modal) return;
    document.getElementById('modal-receipt-id').textContent = id;
    document.getElementById('modal-receipt-purpose').textContent = purpose;
    document.getElementById('modal-receipt-amount').textContent = amount;
    document.getElementById('modal-receipt-date').textContent = date;
    document.getElementById('modal-receipt-channel').textContent = channel;
    modal.classList.remove('hidden');
}

function closeReceipt() {
    const modal = document.getElementById('receipt-modal');
    if (modal) modal.classList.add('hidden');
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeReceipt();
});

// Filter & Search Siswa Logic
function filterStudents(type, btn) {
    document.querySelectorAll('.filter-btn').forEach(b => {
        b.className = 'filter-btn px-3 py-1.5 rounded-lg text-xs font-semibold transition-all bg-white text-slate-600 hover:text-slate-900 border border-slate-200';
    });
    btn.className = 'filter-btn px-3 py-1.5 rounded-lg text-xs font-bold transition-all bg-blue-600 text-white shadow-2xs';

    const searchVal = (document.getElementById('search-siswa-input')?.value || '').toLowerCase().trim();
    applyFilterAndSearch(type, searchVal);
}

function searchStudents(val) {
    const activeBtn = document.querySelector('.filter-btn.bg-blue-600');
    const filterType = activeBtn ? activeBtn.getAttribute('data-filter') : 'all';
    applyFilterAndSearch(filterType, val.toLowerCase().trim());
}

function applyFilterAndSearch(filterType, query) {
    const rows = document.querySelectorAll('.student-row');
    let visibleCount = 0;
    rows.forEach(row => {
        const rowStatus = row.getAttribute('data-status');
        const rowName = row.getAttribute('data-name') || '';
        const rowNis = row.getAttribute('data-nis') || '';

        const matchesFilter = (filterType === 'all') || (rowStatus === filterType);
        const matchesQuery = !query || rowName.includes(query) || rowNis.includes(query);

        if (matchesFilter && matchesQuery) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    const emptyRow = document.getElementById('empty-search-row');
    if (emptyRow) {
        emptyRow.classList.toggle('hidden', visibleCount > 0);
    }
}
</script>
@endpush

