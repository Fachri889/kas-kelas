@extends('layouts.app')

@section('title', 'Catatan Pengeluaran Kas')

@section('content')
<div class="flex flex-col w-full gap-space-lg">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-space-md bg-surface-container-lowest p-space-lg rounded-xl shadow-xs border border-outline-variant/30">
        <div>
            <div class="flex items-center gap-space-xs">
                <h1 class="font-headline-lg text-headline-lg text-on-surface font-bold">Catatan Pengeluaran Kas</h1>
                <span class="px-2 py-0.5 rounded-full bg-error-container text-error font-label-sm font-semibold">4 Mutasi Terverifikasi</span>
            </div>
            <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                Transparansi belanja kelas, arsip nota fisik, dan kwitansi pembelian resmi.
            </p>
        </div>
        <div class="flex items-center gap-space-sm flex-wrap">
            <button type="button" onclick="openExpenseModal()" class="flex items-center gap-2 px-space-md py-2.5 rounded-lg bg-primary-container text-on-primary font-label-lg text-label-lg shadow-sm hover:opacity-90 transition-all">
                <span class="material-symbols-outlined text-[20px]">add_circle</span>
                <span>Catat Pengeluaran Baru</span>
            </button>
            <a href="{{ route('laporan.index') }}" class="flex items-center gap-2 px-space-md py-2.5 rounded-lg bg-surface-container text-on-surface font-label-lg text-label-lg hover:bg-surface-container-high transition-colors">
                <span class="material-symbols-outlined text-[20px]">summarize</span>
                <span>Rekap Keuangan</span>
            </a>
        </div>
    </div>

    <!-- Summary Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-space-md">
        <div class="bg-surface-container-lowest p-4 rounded-xl shadow-xs border border-outline-variant/30 flex items-center justify-between">
            <div>
                <span class="font-label-md text-label-md text-on-surface-variant">Total Pengeluaran Bulan Ini</span>
                <p class="font-headline-md text-headline-md text-error font-bold mt-1">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-error-container/40 text-error flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]">trending_down</span>
            </div>
        </div>
        <div class="bg-surface-container-lowest p-4 rounded-xl shadow-xs border border-outline-variant/30 flex items-center justify-between">
            <div>
                <span class="font-label-md text-label-md text-on-surface-variant">Sisa Saldo Kas Aktif</span>
                <p class="font-headline-md text-headline-md text-secondary font-bold mt-1">Rp {{ number_format($sisaSaldo, 0, ',', '.') }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-secondary-fixed/40 text-secondary flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]">account_balance_wallet</span>
            </div>
        </div>
        <div class="bg-surface-container-lowest p-4 rounded-xl shadow-xs border border-outline-variant/30 flex items-center justify-between">
            <div>
                <span class="font-label-md text-label-md text-on-surface-variant">Jumlah Transaksi Belanja</span>
                <p class="font-headline-md text-headline-md text-on-surface font-bold mt-1">{{ $totalTransaksi }} Transaksi</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]">receipt</span>
            </div>
        </div>
    </div>

    <!-- Pengeluaran Table -->
    <div class="bg-surface-container-lowest rounded-xl shadow-xs border border-outline-variant/30 overflow-hidden">
        <form method="GET" action="{{ route('pengeluaran.index') }}" class="p-space-md border-b border-outline-variant/30 flex flex-col sm:flex-row gap-space-sm items-center justify-between">
            <div class="relative w-full sm:w-80">
                <span class="material-symbols-outlined absolute left-3 top-2.5 text-on-surface-variant text-[20px] pointer-events-none">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari barang, vendor, atau kode..." class="w-full h-10 pl-10 pr-4 rounded-lg bg-surface-container-low border border-outline-variant/50 text-body-md text-on-surface focus:outline-none focus:border-primary-container focus:ring-1 focus:ring-primary-container"/>
            </div>
            <div class="flex items-center gap-space-sm w-full sm:w-auto">
                <select name="kategori" onchange="this.form.submit()" class="h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 text-body-md text-on-surface focus:outline-none">
                    <option value="Semua">Semua Kategori</option>
                    <option value="Perlengkapan Kelas" {{ request('kategori') === 'Perlengkapan Kelas' ? 'selected' : '' }}>Perlengkapan Kelas</option>
                    <option value="Akademik & Ujian" {{ request('kategori') === 'Akademik & Ujian' ? 'selected' : '' }}>Akademik & Ujian</option>
                    <option value="Sosial & Kesehatan" {{ request('kategori') === 'Sosial & Kesehatan' ? 'selected' : '' }}>Sosial & Kesehatan</option>
                    <option value="Kebersihan" {{ request('kategori') === 'Kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                </select>
                @if(request('search') || request('kategori'))
                    <a href="{{ route('pengeluaran.index') }}" class="h-10 px-3 flex items-center gap-1 rounded-lg text-on-surface-variant hover:bg-surface-container-low text-label-md">
                        <span class="material-symbols-outlined text-[18px]">clear</span>
                        <span>Reset</span>
                    </a>
                @endif
            </div>
        </form>

        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low/70 border-b border-outline-variant/30 font-label-md text-label-md text-on-surface-variant">
                        <th class="py-3 px-4">Kode Transaksi</th>
                        <th class="py-3 px-4">Tanggal</th>
                        <th class="py-3 px-4">Deskripsi Belanja</th>
                        <th class="py-3 px-4">Toko / Penerima</th>
                        <th class="py-3 px-4 text-right">Nominal Keluar</th>
                        <th class="py-3 px-4 text-center">Bukti Nota</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20">
                    @forelse($pengeluarans as $exp)
                        <tr class="hover:bg-surface-container-low/40 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-xs text-primary">{{ $exp->kode_transaksi }}</td>
                            <td class="py-3 px-4 text-body-sm text-on-surface-variant">{{ $exp->tanggal->translatedFormat('d M Y') }}</td>
                            <td class="py-3 px-4">
                                <div class="font-label-lg font-semibold text-on-surface leading-tight">{{ $exp->deskripsi }}</div>
                                <span class="font-body-sm text-[11px] text-on-surface-variant">{{ $exp->kategori }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="text-body-sm font-medium text-on-surface block">{{ $exp->toko_vendor }}</span>
                                <span class="text-body-sm text-[11px] text-outline font-mono">{{ $exp->nomor_nota ?? 'Arsip Kas' }}</span>
                            </td>
                            <td class="py-3 px-4 text-right font-label-lg font-bold text-error tabular-nums">
                                -Rp {{ number_format($exp->nominal, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                <button type="button" onclick="showReceiptModal('{{ $exp->kode_transaksi }}', '{{ addslashes($exp->deskripsi) }}', '{{ addslashes($exp->toko_vendor) }}', 'Rp {{ number_format($exp->nominal, 0, ',', '.') }}', '{{ $exp->tanggal->translatedFormat('d M Y') }}', '{{ addslashes($exp->catatan ?? '') }}')" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-secondary-fixed/30 hover:bg-secondary-fixed/50 text-secondary transition-colors text-xs font-semibold">
                                    <span class="material-symbols-outlined text-[16px]">receipt_long</span>
                                    <span>Lihat Nota</span>
                                </button>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <form action="{{ route('pengeluaran.destroy', $exp->id) }}" method="POST" onsubmit="return confirm('Hapus catatan pengeluaran ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg text-on-surface-variant hover:text-error hover:bg-error-container/30 transition-colors" title="Hapus Pengeluaran">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-on-surface-variant">Tidak ada data pengeluaran kas ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Viewer Nota Digital -->
<div id="modal-receipt-view" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs hidden">
    <div class="bg-surface-container-lowest rounded-2xl shadow-xl w-full max-w-md overflow-hidden animate-fadeIn">
        <div class="p-4 bg-surface-container-low flex items-center justify-between">
            <div class="flex flex-col">
                <span class="font-label-sm text-label-sm text-primary font-mono font-bold" id="receipt-modal-code">OUT-2410-04</span>
                <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold" id="receipt-modal-title">Nota Belanja Fisik</h3>
            </div>
            <button type="button" onclick="closeReceiptModal()" class="p-1 rounded-lg text-outline hover:text-on-surface">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <div class="p-5 flex flex-col items-center">
            <!-- Digital Voucher Slip -->
            <div class="w-full rounded-xl border-2 border-dashed border-outline-variant/60 bg-surface-container-lowest p-6 flex flex-col items-center justify-center text-center relative mb-4 shadow-inner">
                <div class="w-14 h-14 rounded-2xl bg-secondary-fixed/40 text-secondary flex items-center justify-center mb-3 shadow-2xs">
                    <span class="material-symbols-outlined text-[32px]">receipt_long</span>
                </div>
                <h4 class="font-headline-sm text-headline-sm text-on-surface mb-1 font-semibold" id="receipt-modal-vendor">Toko Buku Gramedia</h4>
                <p class="font-label-sm text-label-sm text-on-surface-variant font-mono mb-2" id="receipt-modal-date">23 Okt 2024</p>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-secondary-container/50 text-secondary font-label-sm font-semibold">
                    <span class="material-symbols-outlined text-[16px]">verified</span>
                    <span>Dokumen Fisik Terverifikasi Sah</span>
                </div>
            </div>

            <!-- Details -->
            <div class="w-full bg-surface-container-low p-3.5 rounded-xl flex flex-col gap-2 text-body-sm">
                <div class="flex items-center justify-between">
                    <span class="text-on-surface-variant">Total Nominal:</span>
                    <span class="font-bold text-error text-base tabular-nums" id="receipt-modal-amount">Rp 45.000</span>
                </div>
                <div class="flex items-start justify-between">
                    <span class="text-on-surface-variant shrink-0">Catatan:</span>
                    <span class="text-right text-on-surface font-medium" id="receipt-modal-notes">-</span>
                </div>
                <div class="pt-2 border-t border-outline-variant/30 flex items-center justify-between text-[11px] text-secondary">
                    <span class="flex items-center gap-1 font-semibold">
                        <span class="material-symbols-outlined text-[14px]">done_all</span> Disetujui Wali Kelas & Bendahara
                    </span>
                    <span class="text-on-surface-variant">Arsip Binder Kelas</span>
                </div>
            </div>
        </div>
        <div class="p-4 bg-surface-container-low flex justify-end">
            <button type="button" onclick="closeReceiptModal()" class="px-4 py-2 rounded-lg bg-surface-container-lowest text-on-surface hover:bg-surface-container-high transition-colors font-label-lg text-label-lg">
                Tutup Pratinjau
            </button>
        </div>
    </div>
</div>

<!-- Modal: Catat Pengeluaran Baru -->
<div id="modal-expense" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs hidden">
    <div class="bg-surface-container-lowest rounded-2xl shadow-xl w-full max-w-md overflow-hidden animate-fadeIn">
        <div class="p-5 border-b border-outline-variant/30 flex items-center justify-between">
            <div>
                <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">Catat Pengeluaran Kas</h3>
                <span class="font-body-sm text-[11px] text-secondary font-semibold">Sisa Saldo Kas: Rp {{ number_format($sisaSaldo, 0, ',', '.') }}</span>
            </div>
            <button type="button" onclick="closeExpenseModal()" class="p-1 rounded-lg text-on-surface-variant hover:bg-surface-container-low">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <form action="{{ route('pengeluaran.store') }}" method="POST" class="p-5 space-y-4">
            @csrf
            <div>
                <label class="block font-label-md text-label-md text-on-surface mb-1">Kategori Belanja *</label>
                <select name="kategori" required class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface">
                    <option value="Perlengkapan Kelas">Perlengkapan Kelas</option>
                    <option value="Akademik & Ujian">Akademik & Ujian</option>
                    <option value="Sosial & Kesehatan">Sosial & Kesehatan</option>
                    <option value="Kebersihan">Kebersihan</option>
                    <option value="Kegiatan & Acara">Kegiatan & Acara</option>
                </select>
            </div>
            <div>
                <label class="block font-label-md text-label-md text-on-surface mb-1">Nama Barang / Keperluan *</label>
                <input type="text" name="deskripsi" required placeholder="Contoh: Kertas HVS 1 Rim & Tinta Spidol" class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface"/>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1">Nominal (Rp) *</label>
                    <input type="number" name="nominal" min="1000" max="{{ $sisaSaldo }}" step="1000" required placeholder="Contoh: 50000" class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface font-semibold text-error"/>
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1">Tanggal *</label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface"/>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1">Toko / Vendor *</label>
                    <input type="text" name="toko_vendor" required placeholder="Nama Toko / Penerima" class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface"/>
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1">No. Nota / Kwitansi</label>
                    <input type="text" name="nomor_nota" placeholder="Contoh: NOT-091" class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface"/>
                </div>
            </div>
            <div>
                <label class="block font-label-md text-label-md text-on-surface mb-1">Keterangan Tambahan</label>
                <input type="text" name="catatan" placeholder="Detail keperluan belanja kelas" class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface"/>
            </div>
            <div class="pt-3 border-t border-outline-variant/30 flex justify-end gap-2">
                <button type="button" onclick="closeExpenseModal()" class="px-4 py-2 rounded-lg bg-surface-container text-on-surface font-label-lg hover:bg-surface-container-high transition-colors">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-primary-container text-on-primary font-label-lg hover:opacity-90 transition-all">Simpan Pengeluaran</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showReceiptModal(code, title, vendor, amount, date, notes) {
    document.getElementById('receipt-modal-code').innerText = code;
    document.getElementById('receipt-modal-title').innerText = title;
    document.getElementById('receipt-modal-vendor').innerText = vendor;
    document.getElementById('receipt-modal-amount').innerText = amount;
    document.getElementById('receipt-modal-date').innerText = date;
    document.getElementById('receipt-modal-notes').innerText = notes || 'Keperluan resmi kegiatan belajar kelas XII IPA 2.';
    document.getElementById('modal-receipt-view').classList.remove('hidden');
}
function closeReceiptModal() {
    document.getElementById('modal-receipt-view').classList.add('hidden');
}
function openExpenseModal() {
    document.getElementById('modal-expense').classList.remove('hidden');
}
function closeExpenseModal() {
    document.getElementById('modal-expense').classList.add('hidden');
}
</script>
@endpush
