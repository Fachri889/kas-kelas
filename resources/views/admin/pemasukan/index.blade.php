@extends('layouts.admin')

@section('title', 'Buku Pemasukan Kas')

@section('content')
<div class="flex flex-col w-full gap-space-lg">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-space-md bg-surface-container-lowest p-space-lg rounded-xl shadow-xs border border-outline-variant/30">
        <div>
            <div class="flex items-center gap-space-xs">
                <h1 class="font-headline-lg text-headline-lg text-on-surface font-bold">Catatan Pemasukan Kas</h1>
                <span class="px-2 py-0.5 rounded-full bg-secondary-fixed text-secondary font-label-sm font-semibold">Aktif</span>
            </div>
            <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                Catat seluruh dana kas masuk dari iuran mingguan siswa, donasi, serta usaha kelas.
            </p>
        </div>
        <div class="flex flex-row items-center gap-2.5 sm:gap-3 shrink-0 flex-nowrap overflow-x-auto pt-1 sm:pt-0">
            <button type="button" onclick="openIncomeModal()" class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2.5 rounded-xl bg-primary-container text-on-primary font-label-lg text-label-lg shadow-sm hover:opacity-90 transition-all font-semibold whitespace-nowrap">
                <span class="material-symbols-outlined text-[20px]">add_circle</span>
                <span>Tambah Pemasukan</span>
            </button>
            <a href="{{ route('admin.laporan.index') }}" class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2.5 rounded-xl bg-surface-container text-on-surface font-label-lg text-label-lg hover:bg-surface-container-high transition-colors font-medium whitespace-nowrap">
                <span class="material-symbols-outlined text-[20px]">description</span>
                <span>Lihat Rekap</span>
            </a>
        </div>
    </div>

    <!-- Summary Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
        <div class="bg-surface-container-lowest p-4 rounded-xl shadow-xs border border-outline-variant/30 flex items-center justify-between">
            <div>
                <span class="font-label-md text-label-md text-on-surface-variant font-medium">Total Seluruh Masuk</span>
                <p class="font-headline-md text-headline-md text-secondary font-bold mt-1">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-secondary-fixed/40 text-secondary flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]">savings</span>
            </div>
        </div>
        <div class="bg-surface-container-lowest p-4 rounded-xl shadow-xs border border-outline-variant/30 flex items-center justify-between">
            <div>
                <span class="font-label-md text-label-md text-on-surface-variant font-medium">Iuran Kas Siswa</span>
                <p class="font-headline-md text-headline-md text-on-surface font-bold mt-1">Rp {{ number_format($totalIuran, 0, ',', '.') }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]">payments</span>
            </div>
        </div>
        <div class="bg-surface-container-lowest p-4 rounded-xl shadow-xs border border-outline-variant/30 flex items-center justify-between">
            <div>
                <span class="font-label-md text-label-md text-on-surface-variant font-medium">Donasi & Sumbangan</span>
                <p class="font-headline-md text-headline-md text-on-surface font-bold mt-1">Rp {{ number_format($totalDonasi, 0, ',', '.') }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-tertiary-fixed/40 text-tertiary flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]">volunteer_activism</span>
            </div>
        </div>
        <div class="bg-surface-container-lowest p-4 rounded-xl shadow-xs border border-outline-variant/30 flex items-center justify-between">
            <div>
                <span class="font-label-md text-label-md text-on-surface-variant font-medium">Lain-lain & Usaha</span>
                <p class="font-headline-md text-headline-md text-on-surface font-bold mt-1">Rp {{ number_format($totalLainnya, 0, ',', '.') }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-surface-container text-on-surface flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]">storefront</span>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-surface-container-lowest rounded-xl shadow-xs border border-outline-variant/30 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low/70 border-b border-outline-variant/30 font-label-md text-label-md text-on-surface-variant">
                        <th class="py-3 px-4">No. Transaksi</th>
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4">Deskripsi</th>
                        <th class="py-3 px-4">Tanggal</th>
                        <th class="py-3 px-4">Sumber Dana</th>
                        <th class="py-3 px-4 text-right">Nominal</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/15 font-body-md text-body-md">
                    @forelse($pemasukans as $inc)
                        <tr class="hover:bg-surface-container-low/50 transition-colors">
                            <td class="py-3 px-4 font-mono font-medium text-primary text-[12px]">{{ $inc->kode_transaksi }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-0.5 rounded-full bg-secondary-fixed/30 text-secondary font-label-sm font-semibold text-[11px]">
                                    {{ $inc->kategori }}
                                </span>
                            </td>
                            <td class="py-3 px-4 font-semibold text-on-surface">{{ $inc->deskripsi }}</td>
                            <td class="py-3 px-4 text-outline">{{ \Carbon\Carbon::parse($inc->tanggal)->translatedFormat('d M Y') }}</td>
                            <td class="py-3 px-4 text-on-surface-variant">{{ $inc->sumber }}</td>
                            <td class="py-3 px-4 text-right font-bold text-secondary">
                                +Rp {{ number_format($inc->nominal, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                <form action="{{ route('admin.pemasukan.destroy', $inc->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pemasukan ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg text-on-surface-variant hover:text-error hover:bg-error-container/30 transition-colors" title="Hapus Mutasi Pemasukan">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-on-surface-variant">Tidak ada data pemasukan kas ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Tambah Pemasukan Baru -->
<div id="modal-income" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs hidden">
    <div class="bg-surface-container-lowest rounded-2xl shadow-xl w-full max-w-md overflow-hidden animate-fadeIn">
        <div class="p-5 border-b border-outline-variant/30 flex items-center justify-between">
            <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">Tambah Catatan Pemasukan Kas</h3>
            <button type="button" onclick="closeIncomeModal()" class="p-1 rounded-lg text-on-surface-variant hover:bg-surface-container-low">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <form action="{{ route('admin.pemasukan.store') }}" method="POST" class="p-5 space-y-4">
            @csrf
            <div>
                <label class="block font-label-md text-label-md text-on-surface mb-1 font-medium">Kategori Pemasukan *</label>
                <select name="kategori" required class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface">
                    <option value="Iuran Kas">Iuran Kas Mingguan</option>
                    <option value="Donasi">Donasi / Bantuan Sukarela</option>
                    <option value="Usaha Kelas">Usaha Kelas / Penjualan</option>
                    <option value="Subsidi Sekolah">Subsidi Sekolah</option>
                </select>
            </div>
            <div>
                <label class="block font-label-md text-label-md text-on-surface mb-1 font-medium">Deskripsi Pemasukan *</label>
                <input type="text" name="deskripsi" required placeholder="Contoh: Iuran Kas Minggu 4 Kelas XII IPA 2" class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface"/>
            </div>
            <div>
                <label class="block font-label-md text-label-md text-on-surface mb-1 font-medium">Nominal Pemasukan (Rp) *</label>
                <input type="number" name="nominal" min="1000" step="1000" required placeholder="Contoh: 720000" class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface font-semibold"/>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1 font-medium">Tanggal *</label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface"/>
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1 font-medium">Sumber Dana *</label>
                    <input type="text" name="sumber" required placeholder="Contoh: Seluruh Siswa" class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface"/>
                </div>
            </div>
            <div class="pt-3 border-t border-outline-variant/30 flex justify-end gap-2">
                <button type="button" onclick="closeIncomeModal()" class="px-4 py-2 rounded-lg bg-surface-container text-on-surface font-label-lg hover:bg-surface-container-high transition-colors font-medium">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-primary-container text-on-primary font-label-lg hover:opacity-90 transition-all font-semibold">Simpan Pemasukan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openIncomeModal() {
    document.getElementById('modal-income').classList.remove('hidden');
}
function closeIncomeModal() {
    document.getElementById('modal-income').classList.add('hidden');
}
</script>
@endpush
