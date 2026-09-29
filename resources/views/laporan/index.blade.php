@extends('layouts.app')

@section('title', 'Laporan Keuangan Kas')

@section('content')
<div class="flex flex-col w-full gap-6">
    <!-- Header Section -->
    <div class="flex flex-wrap items-center justify-between gap-4 bg-white p-5 sm:p-6 rounded-2xl shadow-xs border border-slate-200/80">
        <div class="min-w-[280px] flex-1">
            <div class="flex flex-wrap items-center gap-2">
                <h1 class="font-headline-lg text-2xl sm:text-3xl text-slate-900 font-bold tracking-tight">Laporan Pertanggungjawaban Kas</h1>
                <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 font-label-sm text-xs font-semibold">Bulan {{ $bulan }} {{ $tahun }}</span>
            </div>
            <p class="font-body-md text-sm text-slate-500 mt-1">
                Rekapitulasi resmi kas kelas XII IPA 2 untuk transparansi siswa dan pihak sekolah.
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-3 shrink-0 no-print w-full sm:w-auto justify-start sm:justify-end">
            <!-- Search Filter Input -->
            <div class="relative w-full sm:w-56 md:w-64">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[18px] pointer-events-none">search</span>
                <input id="laporan-table-search" type="text" class="w-full h-10 pl-9 pr-3 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all" placeholder="Cari transaksi / kode..."/>
            </div>

            <button type="button" onclick="window.print()" class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 text-white font-label-lg text-sm shadow-xs hover:bg-blue-700 active:scale-95 transition-all font-semibold">
                <span class="material-symbols-outlined text-[19px]">print</span>
                <span>Cetak / Cetak PDF</span>
            </button>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-label-lg text-sm hover:bg-slate-200 transition-colors font-medium">
                <span class="material-symbols-outlined text-[19px]">dashboard</span>
                <span>Dashboard</span>
            </a>
        </div>
    </div>

    <!-- Financial Statement Card (Surat Laporan Keuangan) -->
    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-xs border border-slate-200/80 space-y-6">
        <!-- Letterhead / Kop Laporan -->
        <div class="flex items-center justify-between border-b-2 border-slate-200/80 pb-5">
            <div class="flex items-center gap-4">
                <img src="{{ asset('logo.svg') }}" class="w-12 h-12 object-contain shrink-0" alt="Logo"/>
                <div>
                    <h2 class="font-headline-lg text-xl sm:text-2xl text-slate-900 font-bold">KAS KELAS XII IPA 2</h2>
                    <p class="font-body-md text-xs sm:text-sm text-slate-500">SMA NEGERI 1 · TAHUN AJARAN 2024/2025</p>
                </div>
            </div>
            <div class="text-right">
                <span class="font-label-sm text-xs font-mono text-blue-600 font-bold">LPJ-KAS/2024/X</span>
                <p class="font-body-sm text-[11px] text-slate-400 mt-0.5">Tanggal Cetak: {{ date('d F Y') }}</p>
            </div>
        </div>

        <!-- Ikhtisar Saldo Kas -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6">
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 shadow-2xs transition-all hover:bg-slate-100/60">
                <span class="font-label-md text-xs uppercase tracking-wider text-slate-500 font-semibold">Total Penerimaan Kas</span>
                <p class="font-headline-md text-xl sm:text-2xl text-emerald-600 font-bold mt-1.5 tabular-nums">
                    Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                </p>
            </div>
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 shadow-2xs transition-all hover:bg-slate-100/60">
                <span class="font-label-md text-xs uppercase tracking-wider text-slate-500 font-semibold">Total Pengeluaran Kas</span>
                <p class="font-headline-md text-xl sm:text-2xl text-red-600 font-bold mt-1.5 tabular-nums">
                    Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                </p>
            </div>
            <div class="p-5 rounded-2xl bg-blue-50/60 border border-blue-200/80 shadow-2xs transition-all hover:bg-blue-50">
                <span class="font-label-md text-xs uppercase tracking-wider text-blue-700 font-semibold">Sisa Saldo Kas Bersih</span>
                <p class="font-headline-md text-xl sm:text-2xl text-blue-700 font-bold mt-1.5 tabular-nums">
                    Rp {{ number_format($saldoKas, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <!-- Tabel 1: Rincian Pemasukan Kas -->
        <div>
            <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold mb-3 flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-secondary"></span>
                <span>A. Rincian Pemasukan Kas</span>
            </h3>
            <div class="overflow-x-auto border border-outline-variant/30 rounded-xl">
                <table class="w-full text-left border-collapse text-body-sm">
                    <thead>
                        <tr class="bg-surface-container-low font-label-md text-on-surface-variant border-b border-outline-variant/30">
                            <th class="py-2.5 px-3 w-12 text-center">No</th>
                            <th class="py-2.5 px-3">Kode</th>
                            <th class="py-2.5 px-3">Tanggal</th>
                            <th class="py-2.5 px-3">Kategori</th>
                            <th class="py-2.5 px-3">Keterangan / Sumber</th>
                            <th class="py-2.5 px-3 text-right">Nominal (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/20">
                        @foreach($pemasukans as $i => $inc)
                            <tr>
                                <td class="py-2.5 px-3 text-center text-outline">{{ $i + 1 }}</td>
                                <td class="py-2.5 px-3 font-mono font-bold text-xs text-primary">{{ $inc->kode_transaksi }}</td>
                                <td class="py-2.5 px-3 text-on-surface-variant">{{ $inc->tanggal->format('d/m/Y') }}</td>
                                <td class="py-2.5 px-3 font-medium">{{ $inc->kategori }}</td>
                                <td class="py-2.5 px-3 text-on-surface">{{ $inc->deskripsi }} ({{ $inc->sumber }})</td>
                                <td class="py-2.5 px-3 text-right font-bold text-secondary tabular-nums">
                                    {{ number_format($inc->nominal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-surface-container-low font-bold">
                            <td colspan="5" class="py-2.5 px-3 text-right">Total Pemasukan:</td>
                            <td class="py-2.5 px-3 text-right text-secondary tabular-nums">
                                Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Tabel 2: Rincian Pengeluaran Kas -->
        <div>
            <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold mb-3 flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-error"></span>
                <span>B. Rincian Pengeluaran Kas</span>
            </h3>
            <div class="overflow-x-auto border border-outline-variant/30 rounded-xl">
                <table class="w-full text-left border-collapse text-body-sm">
                    <thead>
                        <tr class="bg-surface-container-low font-label-md text-on-surface-variant border-b border-outline-variant/30">
                            <th class="py-2.5 px-3 w-12 text-center">No</th>
                            <th class="py-2.5 px-3">Kode</th>
                            <th class="py-2.5 px-3">Tanggal</th>
                            <th class="py-2.5 px-3">Kategori</th>
                            <th class="py-2.5 px-3">Uraian Kebutuhan & Vendor</th>
                            <th class="py-2.5 px-3 text-right">Nominal (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/20">
                        @foreach($pengeluarans as $i => $exp)
                            <tr>
                                <td class="py-2.5 px-3 text-center text-outline">{{ $i + 1 }}</td>
                                <td class="py-2.5 px-3 font-mono font-bold text-xs text-primary">{{ $exp->kode_transaksi }}</td>
                                <td class="py-2.5 px-3 text-on-surface-variant">{{ $exp->tanggal->format('d/m/Y') }}</td>
                                <td class="py-2.5 px-3 font-medium">{{ $exp->kategori }}</td>
                                <td class="py-2.5 px-3 text-on-surface">{{ $exp->deskripsi }} · <span class="text-outline text-xs">{{ $exp->toko_vendor }}</span></td>
                                <td class="py-2.5 px-3 text-right font-bold text-error tabular-nums">
                                    {{ number_format($exp->nominal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-surface-container-low font-bold">
                            <td colspan="5" class="py-2.5 px-3 text-right">Total Pengeluaran:</td>
                            <td class="py-2.5 px-3 text-right text-error tabular-nums">
                                Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Kolom Pengesahan Tanda Tangan Digital (3 Pihak) -->
        <div class="pt-space-lg border-t-2 border-outline-variant/40">
            <h4 class="font-label-lg text-label-lg text-on-surface-variant text-center mb-space-md uppercase tracking-wider font-semibold">
                LEMBAR PENGESAHAN LAPORAN PERTANGGUNGJAWABAN KAS
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-space-md text-center">
                <!-- 1. Bendahara -->
                <div class="p-4 rounded-xl bg-surface-container-low border border-outline-variant/30 flex flex-col justify-between">
                    <div>
                        <span class="font-label-sm text-[11px] text-on-surface-variant uppercase font-bold">Penyusun / Bendahara</span>
                        <div class="my-3 py-2 bg-surface-container-lowest rounded-lg border border-dashed border-outline-variant/40 flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-primary/10 text-primary font-bold text-xs flex items-center justify-center mb-1">SP</div>
                            <span class="text-[10px] text-secondary font-bold flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">verified</span> TERVERIFIKASI
                            </span>
                        </div>
                    </div>
                    <div>
                        <span class="font-label-lg font-bold text-on-surface block">Salsabila Putri</span>
                        <span class="text-body-sm text-[11px] text-on-surface-variant">NIS: 89190 · Bendahara 1</span>
                    </div>
                </div>

                <!-- 2. Ketua Kelas -->
                <div class="p-4 rounded-xl bg-surface-container-low border border-outline-variant/30 flex flex-col justify-between">
                    <div>
                        <span class="font-label-sm text-[11px] text-on-surface-variant uppercase font-bold">Mengetahui / Ketua Kelas</span>
                        <div class="my-3 py-2 bg-surface-container-lowest rounded-lg border border-dashed border-outline-variant/40 flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-surface-container-high text-primary font-bold text-xs flex items-center justify-center mb-1">MR</div>
                            <span class="text-[10px] text-secondary font-bold flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">verified</span> TERVERIFIKASI
                            </span>
                        </div>
                    </div>
                    <div>
                        <span class="font-label-lg font-bold text-on-surface block">Muhammad Rayhan</span>
                        <span class="text-body-sm text-[11px] text-on-surface-variant">NIS: 89195 · Ketua Kelas</span>
                    </div>
                </div>

                <!-- 3. Wali Kelas -->
                <div class="p-4 rounded-xl bg-surface-container-low border border-outline-variant/30 flex flex-col justify-between">
                    <div>
                        <span class="font-label-sm text-[11px] text-on-surface-variant uppercase font-bold">Menyetujui / Wali Kelas</span>
                        <div class="my-3 py-2 bg-surface-container-lowest rounded-lg border border-dashed border-outline-variant/40 flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-primary-container text-on-primary font-bold text-xs flex items-center justify-center mb-1">NJ</div>
                            <span class="text-[10px] text-primary font-bold flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">approval</span> DISETUJUI SAH
                            </span>
                        </div>
                    </div>
                    <div>
                        <span class="font-label-lg font-bold text-on-surface block">Nurul Jannah, S.Pd.</span>
                        <span class="text-body-sm text-[11px] text-on-surface-variant">NIP: 198503122008012004</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
