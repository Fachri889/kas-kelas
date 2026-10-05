@extends('layouts.admin')

@section('title', 'Catatan Pengeluaran Kas')

@section('content')
    <div class="flex flex-col w-full gap-space-lg">
        <!-- Header Section -->
        <div
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-space-md bg-surface-container-lowest p-space-lg rounded-xl shadow-xs border border-outline-variant/30">
            <div>
                <div class="flex items-center gap-space-xs">
                    <h1 class="font-headline-lg text-headline-lg text-on-surface font-bold">Catatan Pengeluaran Kas</h1>
                    <span class="px-2 py-0.5 rounded-full bg-error-container text-error font-label-sm font-semibold">Mutasi
                        Terverifikasi</span>
                </div>
                <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                    Transparansi belanja kelas, arsip nota fisik, dan kwitansi pembelian resmi.
                </p>
            </div>
            <div class="flex flex-row items-center gap-2.5 sm:gap-3 shrink-0 flex-nowrap overflow-x-auto pt-1 sm:pt-0">
                <button type="button" onclick="openExpenseModal()"
                    class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2.5 rounded-xl bg-primary-container text-on-primary font-label-lg text-label-lg shadow-sm hover:opacity-90 transition-all font-semibold whitespace-nowrap">
                    <span class="material-symbols-outlined text-[20px]">add_circle</span>
                    <span>Catat Pengeluaran Baru</span>
                </button>
                <a href="{{ route('admin.laporan.index') }}"
                    class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2.5 rounded-xl bg-surface-container text-on-surface font-label-lg text-label-lg hover:bg-surface-container-high transition-colors font-medium whitespace-nowrap">
                    <span class="material-symbols-outlined text-[20px]">summarize</span>
                    <span>Rekap Keuangan</span>
                </a>
            </div>
        </div>

        <!-- Summary Metrics -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-space-md">
            <div
                class="bg-surface-container-lowest p-4 rounded-xl shadow-xs border border-outline-variant/30 flex items-center justify-between">
                <div>
                    <span class="font-label-md text-label-md text-on-surface-variant font-medium">Total Pengeluaran Bulan
                        Ini</span>
                    <p class="font-headline-md text-headline-md text-error font-bold mt-1">Rp
                        {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-error-container/40 text-error flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">trending_down</span>
                </div>
            </div>
            <div
                class="bg-surface-container-lowest p-4 rounded-xl shadow-xs border border-outline-variant/30 flex items-center justify-between">
                <div>
                    <span class="font-label-md text-label-md text-on-surface-variant font-medium">Sisa Saldo Kas
                        Aktif</span>
                    <p class="font-headline-md text-headline-md text-secondary font-bold mt-1">Rp
                        {{ number_format($sisaSaldo, 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-secondary-fixed/40 text-secondary flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">account_balance_wallet</span>
                </div>
            </div>
            <div
                class="bg-surface-container-lowest p-4 rounded-xl shadow-xs border border-outline-variant/30 flex items-center justify-between">
                <div>
                    <span class="font-label-md text-label-md text-on-surface-variant font-medium">Total Transaksi
                        Belanja</span>
                    <p class="font-headline-md text-headline-md text-on-surface font-bold mt-1">{{ $totalTransaksi }}
                        Kebutuhan</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-surface-container text-on-surface flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">receipt_long</span>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-surface-container-lowest rounded-xl shadow-xs border border-outline-variant/30 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-surface-container-low/70 border-b border-outline-variant/30 font-label-md text-label-md text-on-surface-variant">
                            <th class="py-3 px-4">No. Transaksi</th>
                            <th class="py-3 px-4">Kategori Belanja</th>
                            <th class="py-3 px-4">Keperluan / Barang</th>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Toko / Penerima</th>
                            <th class="py-3 px-4 text-right">Nominal</th>
                            <th class="py-3 px-4 text-center">Nota & Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/15 font-body-md text-body-md">
                        @forelse($pengeluarans as $exp)
                            <tr class="hover:bg-surface-container-low/50 transition-colors">
                                <td class="py-3 px-4 font-mono font-medium text-primary text-[12px]">{{ $exp->kode_transaksi }}
                                </td>
                                <td class="py-3 px-4">
                                    <span
                                        class="px-2.5 py-0.5 rounded-full bg-surface-container text-on-surface font-label-sm font-semibold text-[11px]">
                                        {{ $exp->kategori }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 font-semibold text-on-surface">{{ $exp->deskripsi }}</td>
                                <td class="py-3 px-4 text-outline">
                                    {{ \Carbon\Carbon::parse($exp->tanggal)->translatedFormat('d M Y') }}</td>
                                <td class="py-3 px-4 text-on-surface-variant">{{ $exp->toko_vendor }}</td>
                                <td class="py-3 px-4 text-right font-bold text-error">
                                    -Rp {{ number_format($exp->nominal, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <button type="button"
                                            onclick="showReceiptModal('{{ $exp->kode_transaksi }}', '{{ $exp->deskripsi }}', '{{ $exp->toko_vendor }}', 'Rp {{ number_format($exp->nominal, 0, ',', '.') }}', '{{ \Carbon\Carbon::parse($exp->tanggal)->translatedFormat('d M Y') }}', '{{ $exp->catatan }}')"
                                            class="p-1.5 rounded-lg text-primary hover:bg-primary-fixed/30 transition-colors"
                                            title="Lihat Kwitansi / Nota">
                                            <span class="material-symbols-outlined text-[18px]">receipt</span>
                                        </button>
                                        <form action="{{ route('admin.pengeluaran.destroy', $exp->id) }}" method="POST"
                                            onsubmit="return confirmAdminDelete(event, this, 'Hapus Mutasi Pengeluaran', 'Apakah Anda yakin ingin membatalkan mutasi pengeluaran ini? Data belanja akan terhapus dari laporan kas.', '{{ addslashes($exp->kode_transaksi) }} - {{ addslashes($exp->deskripsi) }}');"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-1.5 rounded-lg text-on-surface-variant hover:text-error hover:bg-error-container/30 transition-colors"
                                                title="Hapus Mutasi Pengeluaran">
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-on-surface-variant">Tidak ada data pengeluaran kas
                                    ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal: Catat Pengeluaran Baru -->
    <div id="modal-expense"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs hidden">
        <div class="bg-surface-container-lowest rounded-2xl shadow-xl w-full max-w-md overflow-hidden animate-fadeIn">
            <div class="p-5 border-b border-outline-variant/30 flex items-center justify-between">
                <div>
                    <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">Catat Pengeluaran Kas</h3>
                    <span class="font-body-sm text-[11px] text-secondary font-semibold">Sisa Saldo Kas: Rp
                        {{ number_format($sisaSaldo, 0, ',', '.') }}</span>
                </div>
                <button type="button" onclick="closeExpenseModal()"
                    class="p-1 rounded-lg text-on-surface-variant hover:bg-surface-container-low">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>
            <form action="{{ route('admin.pengeluaran.store') }}" method="POST" class="p-5 space-y-4">
                @csrf
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1 font-medium">Kategori Belanja
                        *</label>
                    <select name="kategori" required
                        class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface">
                        <option value="Perlengkapan Kelas">Perlengkapan Kelas</option>
                        <option value="Akademik & Ujian">Akademik & Ujian</option>
                        <option value="Sosial & Kesehatan">Sosial & Kesehatan</option>
                        <option value="Kebersihan">Kebersihan</option>
                        <option value="Kegiatan & Acara">Kegiatan & Acara</option>
                    </select>
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1 font-medium">Nama Barang /
                        Keperluan *</label>
                    <input type="text" name="deskripsi" required placeholder="Contoh: Kertas HVS 1 Rim & Tinta Spidol"
                        class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface" />
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-1 font-medium">Nominal (Rp)
                            *</label>
                        <input type="number" name="nominal" min="1000" max="{{ $sisaSaldo }}" step="1000" required
                            placeholder="Contoh: 50000"
                            class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface font-semibold text-error" />
                    </div>
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-1 font-medium">Tanggal *</label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required
                            class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface" />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-1 font-medium">Toko / Vendor
                            *</label>
                        <input type="text" name="toko_vendor" required placeholder="Nama Toko / Penerima"
                            class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface" />
                    </div>
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-1 font-medium">No. Nota /
                            Kwitansi</label>
                        <input type="text" name="nomor_nota" placeholder="Contoh: NOT-091"
                            class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface" />
                    </div>
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1 font-medium">Keterangan
                        Tambahan</label>
                    <input type="text" name="catatan" placeholder="Detail keperluan belanja kelas"
                        class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface" />
                </div>
                <div class="pt-3 border-t border-outline-variant/30 flex justify-end gap-2">
                    <button type="button" onclick="closeExpenseModal()"
                        class="px-4 py-2 rounded-lg bg-surface-container text-on-surface font-label-lg hover:bg-surface-container-high transition-colors font-medium">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-primary-container text-on-primary font-label-lg hover:opacity-90 transition-all font-semibold">Simpan
                        Pengeluaran</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: View Kwitansi -->
    <div id="modal-receipt-view"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs hidden">
        <div
            class="bg-surface-container-lowest rounded-2xl shadow-xl w-full max-w-sm overflow-hidden animate-fadeIn border border-outline-variant/30">
            <div class="p-4 bg-primary text-on-primary flex items-center justify-between">
                <h3 class="font-headline-sm font-bold">Bukti Pengeluaran Kas</h3>
                <button type="button" onclick="closeReceiptModal()" class="text-white/80 hover:text-white">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>
            <div class="p-5 space-y-3 font-body-sm text-body-sm">
                <div class="flex justify-between border-b pb-2">
                    <span class="text-outline">Kode Transaksi</span>
                    <span class="font-mono font-bold text-primary" id="receipt-modal-code">OUT-2410-01</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-outline">Keperluan</span>
                    <span class="font-semibold text-on-surface" id="receipt-modal-title">-</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-outline">Toko / Penerima</span>
                    <span class="font-semibold text-on-surface" id="receipt-modal-vendor">-</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-outline">Tanggal</span>
                    <span class="text-on-surface" id="receipt-modal-date">-</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-outline">Jumlah</span>
                    <span class="font-bold text-error text-headline-sm" id="receipt-modal-amount">-</span>
                </div>
                <p class="text-outline italic pt-2" id="receipt-modal-notes">-</p>
                <button type="button" onclick="closeReceiptModal()"
                    class="w-full mt-4 py-2 bg-surface-container hover:bg-surface-container-high rounded-lg text-on-surface font-semibold">Tutup</button>
            </div>
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