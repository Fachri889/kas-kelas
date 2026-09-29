@extends('layouts.siswa')

@section('title', 'Riwayat Pembayaran & Kuitansi Siswa')

@section('content')
<div class="flex flex-col w-full gap-6 max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 sm:p-7 rounded-2xl shadow-[0_4px_20px_-2px_rgba(0,0,0,0.05)] border border-slate-100">
        <div>
            <div class="flex items-center gap-2.5">
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Riwayat Pembayaran & Kuitansi Digital</h2>
                <span class="px-2.5 py-1 rounded-full bg-blue-50 text-[#1E40AF] text-xs font-bold border border-blue-100">
                    {{ $siswa ? $siswa->nama : 'Siswa' }}
                </span>
            </div>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Daftar kuitansi resmi atas seluruh iuran kas kelas yang telah terverifikasi oleh Bendahara Kelas.
            </p>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <div class="w-full sm:w-60">
                <select class="w-full bg-slate-50 text-slate-800 font-semibold text-xs py-2.5 px-3 rounded-xl border border-slate-200 shadow-2xs focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all cursor-pointer" 
                        onchange="window.location.href='{{ route('siswa.pembayaran.index') }}?nis=' + this.value">
                    @foreach($allStudents as $st)
                        <option value="{{ $st->nis }}" {{ ($siswa && $siswa->nis === $st->nis) ? 'selected' : '' }}>
                            {{ $st->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <a href="{{ route('siswa.dashboard') }}" 
               class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs sm:text-sm transition-colors">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                <span>Kembali ke Dashboard</span>
            </a>
        </div>
    </div>

    <!-- E. Payment History & Receipt Data Table -->
    <div class="bg-white rounded-2xl shadow-[0_4px_20px_-2px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden">
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
                    @forelse($pembayarans as $p)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- Transaction ID -->
                            <td class="py-4 px-6">
                                <span class="font-mono text-xs font-bold text-[#2563EB] bg-blue-50/80 hover:bg-blue-100 px-2.5 py-1 rounded-md border border-blue-100/80 cursor-pointer inline-block"
                                      onclick="showReceipt('{{ $p->kode_transaksi }}', 'Iuran Minggu ke-{{ $p->minggu_ke }} (Bulan {{ $p->bulan }})', 'Rp {{ number_format($p->nominal, 0, ',', '.') }}', '{{ \Carbon\Carbon::parse($p->tanggal_bayar)->translatedFormat('d F Y, H:i') }} WIB', '{{ strtoupper($p->metode_pembayaran) }}')">
                                    {{ $p->kode_transaksi }}
                                </span>
                            </td>

                            <!-- Description -->
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

                            <!-- Nominal -->
                            <td class="py-4 px-6 text-right font-extrabold text-slate-900">
                                Rp {{ number_format($p->nominal, 0, ',', '.') }}
                            </td>

                            <!-- Action Column: Light-blue Tinted Outline Button -->
                            <td class="py-4 px-6 text-center">
                                <button type="button" 
                                        class="px-3.5 py-1.5 rounded-lg border border-blue-200 bg-blue-50/60 hover:bg-blue-100/70 text-[#1E40AF] text-xs font-bold inline-flex items-center gap-1.5 transition-colors"
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
                                Belum ada data pembayaran kas terverifikasi.
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
</script>
@endpush

