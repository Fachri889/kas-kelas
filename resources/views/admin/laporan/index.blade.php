@extends('layouts.admin')

@section('title', 'Laporan Pertanggungjawaban Kas')

@section('content')
<div class="flex flex-col w-full gap-6 max-w-7xl mx-auto">
    <!-- 1. Executive Slate-to-Navy Gradient Header Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 text-white p-6 sm:p-8 shadow-sm border border-slate-700/60">
        <!-- Subtle ambient radial highlight -->
        <div class="absolute -right-10 -top-16 w-72 h-72 rounded-full bg-slate-700/20 blur-3xl pointer-events-none" aria-hidden="true"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2 max-w-3xl">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight leading-tight">
                    Laporan Pertanggungjawaban Kas
                </h1>

                <p class="text-sm sm:text-base text-slate-300 font-normal leading-relaxed">
                    Rekapitulasi komprehensif arus kas masuk, pengeluaran kas, serta saldo akhir kas kelas XII IPA 2 untuk transparansi siswa, wali murid, dan pihak sekolah.
                </p>
            </div>

            <!-- Live Document Stamp -->
            <div class="flex items-center gap-3.5 bg-slate-800/90 border border-slate-700/80 p-3.5 sm:p-4 rounded-xl shrink-0 self-start lg:self-center shadow-xs">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[24px]">verified</span>
                </div>
                <div class="flex flex-col text-left">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status Dokumen</span>
                    <span class="text-sm font-bold text-emerald-400">Terverifikasi Sah LPJ</span>
                    <span class="text-[10px] text-slate-400 font-mono">Bulan {{ $bulan }} {{ $tahun }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Action Bar Organization with Responsive Flexbox Wrap -->
    <div class="flex flex-wrap items-center justify-between gap-3.5 bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <!-- Search Input -->
        <div class="relative w-full sm:w-72 md:w-80">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[18px] pointer-events-none">search</span>
            <input id="laporan-filter-input" 
                   type="text" 
                   class="w-full h-10 pl-9 pr-3 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all" 
                   placeholder="Cari transaksi, kode, atau keterangan..."/>
        </div>

        <!-- Action Controls -->
        <div class="flex flex-wrap items-center gap-2.5 w-full sm:w-auto justify-start sm:justify-end no-print">
            <div class="hidden md:flex items-center gap-1.5 px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-600">
                <span class="material-symbols-outlined text-[17px] text-slate-500">calendar_month</span>
                <span>{{ $bulan }} {{ $tahun }}</span>
            </div>

            <button type="button" 
                    onclick="window.print()" 
                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 text-white text-xs sm:text-sm font-semibold shadow-xs hover:bg-blue-700 active:scale-95 transition-all">
                <span class="material-symbols-outlined text-[19px]">print</span>
                <span>Cetak / Cetak PDF</span>
            </button>

            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 text-xs sm:text-sm font-semibold hover:bg-slate-200 transition-colors">
                <span class="material-symbols-outlined text-[19px]">dashboard</span>
                <span>Dashboard</span>
            </a>
        </div>
    </div>

    <!-- 3. Financial Summary Metric Cards: Clean 3-Column Responsive Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-6">
        <!-- Total Penerimaan -->
        <div class="bg-white p-5 lg:p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Penerimaan Kas</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[22px]">trending_up</span>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight tabular-nums">
                    Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                </div>
                <div class="flex items-center gap-1.5 mt-2 text-xs text-emerald-600 font-medium">
                    <span class="material-symbols-outlined text-[16px]">check_circle</span>
                    <span>Total dana kas masuk terverifikasi</span>
                </div>
            </div>
        </div>

        <!-- Total Pengeluaran -->
        <div class="bg-white p-5 lg:p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Pengeluaran Kas</span>
                <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 border border-red-100 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[22px]">trending_down</span>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight tabular-nums">
                    Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                </div>
                <div class="flex items-center gap-1.5 mt-2 text-xs text-red-600 font-medium">
                    <span class="material-symbols-outlined text-[16px]">receipt_long</span>
                    <span>Dana terpakai untuk operasional kelas</span>
                </div>
            </div>
        </div>

        <!-- Sisa Saldo Kas -->
        <div class="bg-white p-5 lg:p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Sisa Saldo Kas Bersih</span>
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[22px]">account_balance_wallet</span>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-2xl sm:text-3xl font-extrabold text-blue-700 tracking-tight tabular-nums">
                    Rp {{ number_format($saldoKas, 0, ',', '.') }}
                </div>
                <div class="flex items-center gap-1.5 mt-2 text-xs text-blue-600 font-medium">
                    <span class="material-symbols-outlined text-[16px]">account_balance</span>
                    <span>Saldo kas riil tersedia di rekening bendahara</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. Transparency & Compliance Progress Metric Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-6">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-xs">
                    {{ $totalSiswa }}
                </div>
                <div class="flex flex-col text-left">
                    <span class="text-xs text-slate-500 font-medium">Total Siswa</span>
                    <span class="text-sm font-bold text-slate-800">{{ $totalSiswa }} Siswa Terdaftar</span>
                </div>
            </div>

            <div class="h-8 w-px bg-slate-200 hidden sm:block"></div>

            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-100 flex items-center justify-center font-bold text-xs">
                    {{ $siswaLunas }}
                </div>
                <div class="flex flex-col text-left">
                    <span class="text-xs text-slate-500 font-medium">Siswa Lunas</span>
                    <span class="text-sm font-bold text-emerald-600">{{ $siswaLunas }} Siswa Bebas Tunggakan</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col md:items-end w-full md:w-64 gap-1.5">
            <div class="flex items-center justify-between w-full text-xs font-semibold">
                <span class="text-slate-600">Tingkat Kepatuhan Kas:</span>
                <span class="text-blue-600">{{ $persenLunas }}%</span>
            </div>
            <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                <div class="h-full bg-blue-600 rounded-full transition-all duration-500" style="width: {{ $persenLunas }}%;"></div>
            </div>
        </div>
    </div>

    <!-- 5. Formal Printable Statement Card: Kop & Tabel Rincian -->
    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm space-y-8">
        <!-- Letterhead / Kop Laporan Formal -->
        <div class="flex items-center justify-between border-b-2 border-slate-200 pb-6">
            <div class="flex items-center gap-4">
                <img src="{{ asset('logo.svg') }}" class="w-12 h-12 object-contain shrink-0" alt="Logo Kas Kelas"/>
                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight">KAS KELAS XII IPA 2</h2>
                    <p class="text-xs sm:text-sm text-slate-500 font-medium">SMA NEGERI 1 · TAHUN AJARAN 2024/2025</p>
                </div>
            </div>
            <div class="text-right">
                <span class="font-mono text-xs sm:text-sm text-blue-600 font-bold">LPJ-KAS/2024/X</span>
                <p class="text-[11px] text-slate-400 mt-0.5">Tanggal Cetak: {{ date('d F Y') }}</p>
            </div>
        </div>

        <!-- Section A: Tabel Rincian Pemasukan Kas -->
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <h3 class="text-base sm:text-lg text-slate-900 font-bold flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    <span>A. Rincian Pemasukan Kas</span>
                </h3>
                <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 text-xs font-semibold">
                    {{ count($pemasukans) }} Transaksi Masuk
                </span>
            </div>

            <!-- Responsive Table Container -->
            <div class="overflow-x-auto rounded-xl border border-slate-200/80">
                <table class="w-full text-left text-xs sm:text-sm border-collapse data-table" id="table-pemasukan">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200/80">
                            <th class="py-3 px-3.5 w-12 text-center">No</th>
                            <th class="py-3 px-3.5">Kode Transaksi</th>
                            <th class="py-3 px-3.5">Tanggal</th>
                            <th class="py-3 px-3.5">Kategori</th>
                            <th class="py-3 px-3.5">Keterangan / Sumber</th>
                            <th class="py-3 px-3.5 text-right">Nominal (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pemasukans as $i => $inc)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-3 px-3.5 text-center text-slate-400 font-medium">{{ $i + 1 }}</td>
                                <td class="py-3 px-3.5 font-mono font-bold text-xs text-blue-600">{{ $inc->kode_transaksi }}</td>
                                <td class="py-3 px-3.5 text-slate-600 whitespace-nowrap">{{ \Carbon\Carbon::parse($inc->tanggal)->format('d/m/Y') }}</td>
                                <td class="py-3 px-3.5 font-semibold text-slate-800">{{ $inc->kategori }}</td>
                                <td class="py-3 px-3.5 text-slate-700">{{ $inc->deskripsi }} ({{ $inc->sumber }})</td>
                                <td class="py-3 px-3.5 text-right font-bold text-emerald-600 tabular-nums whitespace-nowrap">
                                    {{ number_format($inc->nominal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-1.5">
                                        <span class="material-symbols-outlined text-[28px] text-slate-300">inbox</span>
                                        <span class="text-xs font-medium">Belum ada catatan transaksi pemasukan.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="bg-slate-50 font-bold border-t border-slate-200">
                            <td colspan="5" class="py-3 px-3.5 text-right text-slate-700">Subtotal Penerimaan:</td>
                            <td class="py-3 px-3.5 text-right text-emerald-600 tabular-nums whitespace-nowrap">
                                Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Section B: Tabel Rincian Pengeluaran Kas -->
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <h3 class="text-base sm:text-lg text-slate-900 font-bold flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                    <span>B. Rincian Pengeluaran Kas</span>
                </h3>
                <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 text-xs font-semibold">
                    {{ count($pengeluarans) }} Transaksi Keluar
                </span>
            </div>

            <!-- Responsive Table Container -->
            <div class="overflow-x-auto rounded-xl border border-slate-200/80">
                <table class="w-full text-left text-xs sm:text-sm border-collapse data-table" id="table-pengeluaran">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200/80">
                            <th class="py-3 px-3.5 w-12 text-center">No</th>
                            <th class="py-3 px-3.5">Kode Transaksi</th>
                            <th class="py-3 px-3.5">Tanggal</th>
                            <th class="py-3 px-3.5">Kategori</th>
                            <th class="py-3 px-3.5">Uraian Kebutuhan & Vendor</th>
                            <th class="py-3 px-3.5 text-right">Nominal (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pengeluarans as $i => $exp)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-3 px-3.5 text-center text-slate-400 font-medium">{{ $i + 1 }}</td>
                                <td class="py-3 px-3.5 font-mono font-bold text-xs text-blue-600">{{ $exp->kode_transaksi }}</td>
                                <td class="py-3 px-3.5 text-slate-600 whitespace-nowrap">{{ \Carbon\Carbon::parse($exp->tanggal)->format('d/m/Y') }}</td>
                                <td class="py-3 px-3.5 font-semibold text-slate-800">{{ $exp->kategori }}</td>
                                <td class="py-3 px-3.5 text-slate-700">
                                    {{ $exp->deskripsi }}
                                    @if(!empty($exp->toko_vendor))
                                        <span class="text-xs text-slate-400 font-normal">· {{ $exp->toko_vendor }}</span>
                                    @endif
                                </td>
                                <td class="py-3 px-3.5 text-right font-bold text-red-600 tabular-nums whitespace-nowrap">
                                    {{ number_format($exp->nominal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-1.5">
                                        <span class="material-symbols-outlined text-[28px] text-slate-300">inbox</span>
                                        <span class="text-xs font-medium">Belum ada catatan transaksi pengeluaran.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="bg-slate-50 font-bold border-t border-slate-200">
                            <td colspan="5" class="py-3 px-3.5 text-right text-slate-700">Subtotal Pengeluaran:</td>
                            <td class="py-3 px-3.5 text-right text-red-600 tabular-nums whitespace-nowrap">
                                Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Section C: Lembar Pengesahan Tanda Tangan Digital (3 Pihak) -->
        <div class="pt-6 border-t-2 border-slate-200/80">
            <h4 class="text-xs font-bold text-slate-500 text-center mb-6 uppercase tracking-wider">
                LEMBAR PENGESAHAN LAPORAN PERTANGGUNGJAWABAN KAS
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 lg:gap-6 text-center">
                <!-- 1. Bendahara -->
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col justify-between">
                    <div>
                        <span class="text-[11px] text-slate-500 uppercase font-bold tracking-wider">Penyusun / Bendahara</span>
                        <div class="my-3 py-2 bg-white rounded-xl border border-dashed border-slate-300 flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-700 font-bold text-xs flex items-center justify-center mb-1">SP</div>
                            <span class="text-[10px] text-emerald-600 font-bold flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">verified</span> TERVERIFIKASI
                            </span>
                        </div>
                    </div>
                    <div>
                        <span class="text-sm font-bold text-slate-900 block">Salsabila Putri</span>
                        <span class="text-xs text-slate-500">NIS: 89190 · Bendahara 1</span>
                    </div>
                </div>

                <!-- 2. Ketua Kelas -->
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col justify-between">
                    <div>
                        <span class="text-[11px] text-slate-500 uppercase font-bold tracking-wider">Mengetahui / Ketua Kelas</span>
                        <div class="my-3 py-2 bg-white rounded-xl border border-dashed border-slate-300 flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-800 font-bold text-xs flex items-center justify-center mb-1">MR</div>
                            <span class="text-[10px] text-emerald-600 font-bold flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">verified</span> TERVERIFIKASI
                            </span>
                        </div>
                    </div>
                    <div>
                        <span class="text-sm font-bold text-slate-900 block">Muhammad Rayhan</span>
                        <span class="text-xs text-slate-500">NIS: 89195 · Ketua Kelas</span>
                    </div>
                </div>

                <!-- 3. Wali Kelas -->
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col justify-between">
                    <div>
                        <span class="text-[11px] text-slate-500 uppercase font-bold tracking-wider">Menyetujui / Wali Kelas</span>
                        <div class="my-3 py-2 bg-white rounded-xl border border-dashed border-slate-300 flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-600 text-white font-bold text-xs flex items-center justify-center mb-1">NJ</div>
                            <span class="text-[10px] text-blue-700 font-bold flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">approval</span> DISETUJUI SAH
                            </span>
                        </div>
                    </div>
                    <div>
                        <span class="text-sm font-bold text-slate-900 block">Nurul Jannah, S.Pd.</span>
                        <span class="text-xs text-slate-500">NIP: 198503122008012004</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterInput = document.getElementById('laporan-filter-input');
        if (filterInput) {
            filterInput.addEventListener('input', function (e) {
                const query = e.target.value.toLowerCase().trim();
                const tables = document.querySelectorAll('table.data-table tbody');
                
                tables.forEach(tbody => {
                    const rows = tbody.querySelectorAll('tr');
                    rows.forEach(row => {
                        const text = row.innerText.toLowerCase();
                        row.style.display = text.includes(query) ? '' : 'none';
                    });
                });
            });
        }
    });
</script>
@endpush
