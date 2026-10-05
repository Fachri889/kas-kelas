@extends('layouts.app')

@section('title', 'Pembayaran Iuran Kas')

@section('content')
<div class="flex flex-col w-full gap-space-lg">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-surface-container-lowest p-5 sm:p-6 rounded-2xl shadow-xs border border-outline-variant/30">
        <div class="min-w-0 flex-1">
            <div class="flex items-center gap-space-xs flex-wrap">
                <h1 class="font-headline-lg text-headline-lg text-on-surface font-bold">Matriks Pembayaran Kas</h1>
                <span class="px-2.5 py-0.5 rounded-full bg-secondary-fixed text-secondary font-label-sm font-semibold whitespace-nowrap">Bulan {{ $bulan }} {{ $tahun }}</span>
            </div>
            <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                Catat dan pantau pembayaran kas mingguan (Rp 5.000/minggu) per siswa.
            </p>
        </div>
        <div class="flex flex-row items-center gap-2.5 sm:gap-3 shrink-0 flex-nowrap overflow-x-auto pt-1 sm:pt-0">
            <button type="button" onclick="openPaymentModal()" class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2.5 rounded-xl bg-primary-container text-on-primary font-label-lg text-label-lg shadow-sm hover:opacity-90 transition-all font-semibold whitespace-nowrap">
                <span class="material-symbols-outlined text-[20px]">add_card</span>
                <span>Catat Pembayaran Baru</span>
            </button>
            <a href="{{ route('pemasukan.index') }}" class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2.5 rounded-xl bg-surface-container text-on-surface font-label-lg text-label-lg hover:bg-surface-container-high transition-colors font-medium whitespace-nowrap">
                <span class="material-symbols-outlined text-[20px]">account_balance</span>
                <span>Buku Pemasukan</span>
            </a>
        </div>
    </div>

    <!-- Matriks Pembayaran Mingguan Siswa -->
    <div class="bg-surface-container-lowest rounded-xl shadow-xs border border-outline-variant/30 overflow-hidden">
        <div class="p-space-md border-b border-outline-variant/30 flex items-center justify-between flex-wrap gap-2">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[22px]">calendar_month</span>
                <h2 class="font-headline-sm text-headline-sm text-on-surface font-bold">Status Mingguan Siswa (Oktober 2024)</h2>
            </div>
            <span class="font-body-sm text-body-sm text-on-surface-variant">Target per siswa: Rp 20.000 (4 Minggu × Rp 5.000)</span>
        </div>

        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low/70 border-b border-outline-variant/30 font-label-md text-label-md text-on-surface-variant">
                        <th class="py-3 px-4 w-12 text-center">No</th>
                        <th class="py-3 px-4">Nama Siswa</th>
                        <th class="py-3 px-4 text-center">Minggu 1 (04 Okt)</th>
                        <th class="py-3 px-4 text-center">Minggu 2 (11 Okt)</th>
                        <th class="py-3 px-4 text-center">Minggu 3 (18 Okt)</th>
                        <th class="py-3 px-4 text-center">Minggu 4 (25 Okt)</th>
                        <th class="py-3 px-4 text-right">Total Bayar</th>
                        <th class="py-3 px-4 text-center">Aksi Bayar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20">
                    @foreach($siswas as $idx => $s)
                        @php
                            $paidWeeks = $s->pembayarans->pluck('minggu_ke')->toArray();
                            // If student has total_terbayar, estimate weeks paid if records are sparse
                            $effectiveWeeks = max(count($paidWeeks), (int) floor($s->total_terbayar / 5000));
                        @endphp
                        <tr class="hover:bg-surface-container-low/40 transition-colors">
                            <td class="py-3 px-4 text-center font-label-sm text-outline">{{ $idx + 1 }}</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-primary/10 text-primary font-bold text-xs flex items-center justify-center shrink-0">
                                        {{ $s->initials }}
                                    </div>
                                    <div>
                                        <span class="font-label-lg text-label-lg text-on-surface font-semibold block">{{ $s->nama }}</span>
                                    </div>
                                </div>
                            </td>
                            @for($w = 1; $w <= 4; $w++)
                                <td class="py-3 px-4 text-center">
                                    @if(in_array($w, $paidWeeks) || $effectiveWeeks >= $w)
                                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-secondary-container/50 text-secondary" title="Minggu {{ $w }}: Lunas">
                                            <span class="material-symbols-outlined text-[18px]">check</span>
                                        </span>
                                    @else
                                        <button type="button" onclick="quickPay({{ $s->id }}, '{{ addslashes($s->nama) }}', {{ $w }})" class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-surface-container-high text-on-surface-variant hover:bg-primary-container hover:text-on-primary transition-colors text-xs font-semibold" title="Klik untuk bayar Minggu {{ $w }}">
                                            +
                                        </button>
                                    @endif
                                </td>
                            @endfor
                            <td class="py-3 px-4 text-right font-label-lg font-bold tabular-nums {{ $s->total_terbayar >= 20000 ? 'text-secondary' : 'text-on-surface' }}">
                                Rp {{ number_format($s->total_terbayar, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                <button type="button" onclick="openPaymentModalForStudent({{ $s->id }}, '{{ addslashes($s->nama) }}')" class="px-3 py-1 rounded-lg bg-surface-container hover:bg-primary-container hover:text-on-primary text-on-surface text-label-sm font-semibold transition-colors">
                                    + Input Kas
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Riwayat Transaksi Pembayaran Terakhir -->
    <div class="bg-surface-container-lowest rounded-xl shadow-xs border border-outline-variant/30 overflow-hidden">
        <div class="p-space-md border-b border-outline-variant/30 flex items-center justify-between">
            <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">Riwayat Pembayaran Kas Terbaru</h3>
            <span class="font-body-sm text-body-sm text-on-surface-variant">10 Entri Terbaru</span>
        </div>
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low/70 border-b border-outline-variant/30 font-label-md text-label-md text-on-surface-variant">
                        <th class="py-3 px-4">Kode Transaksi</th>
                        <th class="py-3 px-4">Nama Siswa</th>
                        <th class="py-3 px-4">Periode</th>
                        <th class="py-3 px-4 text-right">Nominal</th>
                        <th class="py-3 px-4">Tanggal Bayar</th>
                        <th class="py-3 px-4 text-center">Metode</th>
                        <th class="py-3 px-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20">
                    @forelse($recentPayments as $p)
                        <tr class="hover:bg-surface-container-low/40 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-xs text-primary">{{ $p->kode_transaksi }}</td>
                            <td class="py-3 px-4 font-label-lg font-semibold text-on-surface">{{ $p->siswa->nama ?? 'Siswa' }}</td>
                            <td class="py-3 px-4 font-body-sm text-on-surface-variant">Minggu ke-{{ $p->minggu_ke }} ({{ $p->bulan }})</td>
                            <td class="py-3 px-4 text-right font-label-lg font-bold text-secondary tabular-nums">
                                Rp {{ number_format($p->nominal, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-body-sm text-on-surface-variant">{{ $p->tanggal_bayar->translatedFormat('d M Y') }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-2 py-0.5 rounded-full bg-surface-container-high text-[11px] font-semibold text-on-surface uppercase">
                                    {{ $p->metode_pembayaran }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-secondary-container/50 text-secondary font-label-sm text-[11px] font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                    Lunas
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-6 text-center text-on-surface-variant">Belum ada riwayat transaksi pembayaran kas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Catat Pembayaran Baru -->
<div id="modal-payment" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs hidden">
    <div class="bg-surface-container-lowest rounded-2xl shadow-xl w-full max-w-md overflow-hidden animate-fadeIn">
        <div class="p-5 border-b border-outline-variant/30 flex items-center justify-between">
            <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">Catat Pembayaran Iuran Kas</h3>
            <button type="button" onclick="closePaymentModal()" class="p-1 rounded-lg text-on-surface-variant hover:bg-surface-container-low">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <form action="{{ route('pembayaran.store') }}" method="POST" class="p-5 space-y-4">
            @csrf
            <div>
                <label class="block font-label-md text-label-md text-on-surface mb-1">Pilih Siswa *</label>
                <select id="payment-siswa-id" name="siswa_id" required class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface">
                    @foreach($siswas as $s)
                        <option value="{{ $s->id }}">{{ $s->nama }} - Sisa: Rp {{ number_format($s->sisa_kas, 0, ',', '.') }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1">Untuk Minggu Ke- *</label>
                    <select id="payment-minggu" name="minggu_ke" required class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface">
                        <option value="1">Minggu 1</option>
                        <option value="2">Minggu 2</option>
                        <option value="3">Minggu 3</option>
                        <option value="4" selected>Minggu 4</option>
                    </select>
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1">Bulan & Tahun *</label>
                    <input type="text" name="bulan" value="Oktober" class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none text-body-md text-on-surface" readonly/>
                    <input type="hidden" name="tahun" value="2024"/>
                </div>
            </div>
            <div>
                <label class="block font-label-md text-label-md text-on-surface mb-1">Nominal Pembayaran (Rp) *</label>
                <input type="number" id="payment-nominal" name="nominal" value="5000" min="1000" step="1000" required class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface font-semibold"/>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1">Tanggal Bayar *</label>
                    <input type="date" name="tanggal_bayar" value="{{ date('Y-m-d') }}" required class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface"/>
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1">Metode Bayar *</label>
                    <select name="metode_pembayaran" required class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface">
                        <option value="tunai">Tunai / Cash</option>
                        <option value="qris">QRIS Kelas</option>
                        <option value="transfer">Transfer Bank</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block font-label-md text-label-md text-on-surface mb-1">Catatan (Opsional)</label>
                <input type="text" name="catatan" placeholder="Catatan bukti bayar / titipan" class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface"/>
            </div>
            <div class="pt-3 border-t border-outline-variant/30 flex justify-end gap-2">
                <button type="button" onclick="closePaymentModal()" class="px-4 py-2 rounded-lg bg-surface-container text-on-surface font-label-lg hover:bg-surface-container-high transition-colors">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-primary-container text-on-primary font-label-lg hover:opacity-90 transition-all">Simpan Pembayaran</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openPaymentModal() {
    document.getElementById('modal-payment').classList.remove('hidden');
}
function closePaymentModal() {
    document.getElementById('modal-payment').classList.add('hidden');
}
function openPaymentModalForStudent(siswaId, nama) {
    document.getElementById('payment-siswa-id').value = siswaId;
    openPaymentModal();
}
function quickPay(siswaId, nama, minggu) {
    document.getElementById('payment-siswa-id').value = siswaId;
    document.getElementById('payment-minggu').value = minggu;
    document.getElementById('payment-nominal').value = 5000;
    openPaymentModal();
}
</script>
@endpush
