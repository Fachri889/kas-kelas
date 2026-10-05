@extends('layouts.app')

@section('title', 'Buku Pemasukan Kas')

@section('content')
    <div class="flex flex-col w-full gap-space-lg">
        <!-- Header Section -->
        <div
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-space-md bg-surface-container-lowest p-space-lg rounded-xl shadow-xs border border-outline-variant/30">
            <div>
                <div class="flex items-center gap-space-xs">
                    <h1 class="font-headline-lg text-headline-lg text-on-surface font-bold">Catatan Pemasukan Kas</h1>
                    <span
                        class="px-2 py-0.5 rounded-full bg-secondary-fixed text-secondary font-label-sm font-semibold">Aktif</span>
                </div>
                <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                    Catat seluruh dana kas masuk dari iuran mingguan siswa, donasi, serta usaha kelas.
                </p>
            </div>
            <div class="flex items-center gap-space-sm flex-wrap">
                <button type="button" onclick="openIncomeModal()"
                    class="flex items-center gap-2 px-space-md py-2.5 rounded-lg bg-primary-container text-on-primary font-label-lg text-label-lg shadow-sm hover:opacity-90 transition-all">
                    <span class="material-symbols-outlined text-[20px]">add_circle</span>
                    <span>Tambah Pemasukan</span>
                </button>
                <a href="{{ route('laporan.index') }}"
                    class="flex items-center gap-2 px-space-md py-2.5 rounded-lg bg-surface-container text-on-surface font-label-lg text-label-lg hover:bg-surface-container-high transition-colors">
                    <span class="material-symbols-outlined text-[20px]">description</span>
                    <span>Lihat Rekap</span>
                </a>
            </div>
        </div>

        <!-- Summary Metrics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
            <div
                class="bg-surface-container-lowest p-4 rounded-xl shadow-xs border border-outline-variant/30 flex items-center justify-between">
                <div>
                    <span class="font-label-md text-label-md text-on-surface-variant">Total Seluruh Masuk</span>
                    <p class="font-headline-md text-headline-md text-secondary font-bold mt-1">Rp
                        {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-secondary-fixed/40 text-secondary flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">savings</span>
                </div>
            </div>
            <div
                class="bg-surface-container-lowest p-4 rounded-xl shadow-xs border border-outline-variant/30 flex items-center justify-between">
                <div>
                    <span class="font-label-md text-label-md text-on-surface-variant">Iuran Kas Siswa</span>
                    <p class="font-headline-md text-headline-md text-on-surface font-bold mt-1">Rp
                        {{ number_format($totalIuran, 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">groups</span>
                </div>
            </div>
            <div
                class="bg-surface-container-lowest p-4 rounded-xl shadow-xs border border-outline-variant/30 flex items-center justify-between">
                <div>
                    <span class="font-label-md text-label-md text-on-surface-variant">Donasi & Sukarela</span>
                    <p class="font-headline-md text-headline-md text-on-surface font-bold mt-1">Rp
                        {{ number_format($totalDonasi, 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">volunteer_activism</span>
                </div>
            </div>
            <div
                class="bg-surface-container-lowest p-4 rounded-xl shadow-xs border border-outline-variant/30 flex items-center justify-between">
                <div>
                    <span class="font-label-md text-label-md text-on-surface-variant">Usaha & Lain-lain</span>
                    <p class="font-headline-md text-headline-md text-on-surface font-bold mt-1">Rp
                        {{ number_format($totalLainnya, 0, ',', '.') }}</p>
                </div>
                <div
                    class="w-10 h-10 rounded-xl bg-surface-container-high text-on-surface flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">storefront</span>
                </div>
            </div>
        </div>

        <!-- Pemasukan Table -->
        <div class="bg-surface-container-lowest rounded-xl shadow-xs border border-outline-variant/30 overflow-hidden">
            <form method="GET" action="{{ route('pemasukan.index') }}"
                class="p-space-md border-b border-outline-variant/30 flex flex-col sm:flex-row gap-space-sm items-center justify-between">
                <div class="relative w-full sm:w-80">
                    <span
                        class="material-symbols-outlined absolute left-3 top-2.5 text-on-surface-variant text-[20px] pointer-events-none">search</span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari deskripsi, kode, atau sumber..."
                        class="w-full h-10 pl-10 pr-4 rounded-lg bg-surface-container-low border border-outline-variant/50 text-body-md text-on-surface focus:outline-none focus:border-primary-container focus:ring-1 focus:ring-primary-container" />
                </div>
                <div class="flex items-center gap-space-sm w-full sm:w-auto">
                    <select name="kategori" onchange="this.form.submit()"
                        class="h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 text-body-md text-on-surface focus:outline-none">
                        <option value="Semua">Semua Kategori</option>
                        <option value="Iuran Kas" {{ request('kategori') === 'Iuran Kas' ? 'selected' : '' }}>Iuran Kas
                        </option>
                        <option value="Donasi" {{ request('kategori') === 'Donasi' ? 'selected' : '' }}>Donasi</option>
                        <option value="Usaha Kelas" {{ request('kategori') === 'Usaha Kelas' ? 'selected' : '' }}>Usaha Kelas
                        </option>
                    </select>
                    @if(request('search') || request('kategori'))
                        <a href="{{ route('pemasukan.index') }}"
                            class="h-10 px-3 flex items-center gap-1 rounded-lg text-on-surface-variant hover:bg-surface-container-low text-label-md">
                            <span class="material-symbols-outlined text-[18px]">clear</span>
                            <span>Reset</span>
                        </a>
                    @endif
                </div>
            </form>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-surface-container-low/70 border-b border-outline-variant/30 font-label-md text-label-md text-on-surface-variant">
                            <th class="py-3 px-4">Kode</th>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Kategori</th>
                            <th class="py-3 px-4">Deskripsi Transaksi</th>
                            <th class="py-3 px-4">Sumber Dana</th>
                            <th class="py-3 px-4 text-right">Nominal Masuk</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/20">
                        @forelse($pemasukans as $inc)
                            <tr class="hover:bg-surface-container-low/40 transition-colors">
                                <td class="py-3 px-4 font-mono font-bold text-xs text-primary">{{ $inc->kode_transaksi }}</td>
                                <td class="py-3 px-4 text-body-sm text-on-surface-variant">
                                    {{ $inc->tanggal->translatedFormat('d M Y') }}</td>
                                <td class="py-3 px-4">
                                    <span
                                        class="px-2.5 py-0.5 rounded-full bg-primary/10 text-primary text-[11px] font-semibold">
                                        {{ $inc->kategori }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 font-label-lg font-semibold text-on-surface">{{ $inc->deskripsi }}</td>
                                <td class="py-3 px-4 text-body-sm text-on-surface-variant">{{ $inc->sumber }}</td>
                                <td class="py-3 px-4 text-right font-label-lg font-bold text-secondary tabular-nums">
                                    +Rp {{ number_format($inc->nominal, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <form action="{{ route('pemasukan.destroy', $inc->id) }}" method="POST"
                                        onsubmit="return handleConfirmDelete(event, this, 'Hapus Catatan Pemasukan', 'Apakah Anda yakin ingin membatalkan catatan pemasukan {{ $inc->kode_transaksi }}? Mutasi ini akan dihapus dari buku kas.');"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-1.5 rounded-lg text-on-surface-variant hover:text-error hover:bg-error-container/30 transition-colors"
                                            title="Hapus Mutasi Pemasukan">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-on-surface-variant">Tidak ada data pemasukan kas
                                    ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal: Tambah Pemasukan Baru -->
    <div id="modal-income"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs hidden">
        <div class="bg-surface-container-lowest rounded-2xl shadow-xl w-full max-w-md overflow-hidden animate-fadeIn">
            <div class="p-5 border-b border-outline-variant/30 flex items-center justify-between">
                <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">Tambah Catatan Pemasukan Kas</h3>
                <button type="button" onclick="closeIncomeModal()"
                    class="p-1 rounded-lg text-on-surface-variant hover:bg-surface-container-low">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>
            <form action="{{ route('pemasukan.store') }}" method="POST" class="p-5 space-y-4">
                @csrf
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1">Kategori Pemasukan *</label>
                    <select name="kategori" required
                        class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface">
                        <option value="Iuran Kas">Iuran Kas Mingguan</option>
                        <option value="Donasi">Donasi / Bantuan Sukarela</option>
                        <option value="Usaha Kelas">Usaha Kelas / Penjualan</option>
                        <option value="Subsidi Sekolah">Subsidi Sekolah</option>
                    </select>
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1">Deskripsi Pemasukan *</label>
                    <input type="text" name="deskripsi" required placeholder="Contoh: Iuran Kas Minggu 4 Kelas XII IPA 2"
                        class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface" />
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1">Nominal Pemasukan (Rp) *</label>
                    <input type="number" name="nominal" min="1000" step="1000" required placeholder="Contoh: 720000"
                        class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface font-semibold" />
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-1">Tanggal *</label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required
                            class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface" />
                    </div>
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-1">Sumber Dana *</label>
                        <input type="text" name="sumber" required placeholder="Contoh: Seluruh Siswa"
                            class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface" />
                    </div>
                </div>
                <div class="pt-3 border-t border-outline-variant/30 flex justify-end gap-2">
                    <button type="button" onclick="closeIncomeModal()"
                        class="px-4 py-2 rounded-lg bg-surface-container text-on-surface font-label-lg hover:bg-surface-container-high transition-colors">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-primary-container text-on-primary font-label-lg hover:opacity-90 transition-all">Simpan
                        Pemasukan</button>
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