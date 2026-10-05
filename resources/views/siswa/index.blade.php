@extends('layouts.app')

@section('title', 'Data Siswa & Kas')

@section('content')
<div class="flex flex-col w-full gap-space-lg">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-space-md bg-surface-container-lowest p-space-lg rounded-xl shadow-xs border border-outline-variant/30">
        <div>
            <div class="flex items-center gap-space-xs">
                <h1 class="font-headline-lg text-headline-lg text-on-surface font-bold">Data Siswa & Kepatuhan Kas</h1>
                <span class="px-2 py-0.5 rounded-full bg-primary-fixed text-primary font-label-sm font-semibold">Kelas XII IPA 2</span>
            </div>
            <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                Kelola status pembayaran, data kontak orang tua, dan mutasi iuran per siswa.
            </p>
        </div>
        <div class="flex items-center gap-space-sm flex-wrap">
            <button type="button" onclick="openAddStudentModal()" class="flex items-center gap-2 px-space-md py-2.5 rounded-lg bg-primary-container text-on-primary font-label-lg text-label-lg shadow-sm hover:opacity-90 transition-all">
                <span class="material-symbols-outlined text-[20px]">person_add</span>
                <span>Tambah Siswa</span>
            </button>
            <a href="{{ route('pembayaran.index') }}" class="flex items-center gap-2 px-space-md py-2.5 rounded-lg bg-surface-container text-on-surface font-label-lg text-label-lg hover:bg-surface-container-high transition-colors">
                <span class="material-symbols-outlined text-[20px]">payments</span>
                <span>Input Pembayaran</span>
            </a>
        </div>
    </div>

    <!-- Summary Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
        <div class="bg-surface-container-lowest p-4 rounded-xl shadow-xs border border-outline-variant/30 flex items-center justify-between">
            <div>
                <span class="font-label-md text-label-md text-on-surface-variant">Total Siswa</span>
                <p class="font-headline-md text-headline-md text-on-surface font-bold mt-1">{{ $totalSiswa }} Anak</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]">groups</span>
            </div>
        </div>
        <div class="bg-surface-container-lowest p-4 rounded-xl shadow-xs border border-outline-variant/30 flex items-center justify-between">
            <div>
                <span class="font-label-md text-label-md text-on-surface-variant">Siswa Lunas</span>
                <p class="font-headline-md text-headline-md text-secondary font-bold mt-1">{{ $totalLunas }} Siswa</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-secondary-fixed/40 text-secondary flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]">check_circle</span>
            </div>
        </div>
        <div class="bg-surface-container-lowest p-4 rounded-xl shadow-xs border border-outline-variant/30 flex items-center justify-between">
            <div>
                <span class="font-label-md text-label-md text-on-surface-variant">Belum Lunas</span>
                <p class="font-headline-md text-headline-md text-error font-bold mt-1">{{ $totalBelumLunas }} Siswa</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-error-container/40 text-error flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]">pending</span>
            </div>
        </div>
        <div class="bg-surface-container-lowest p-4 rounded-xl shadow-xs border border-outline-variant/30 flex items-center justify-between">
            <div>
                <span class="font-label-md text-label-md text-on-surface-variant">Total Terkumpul</span>
                <p class="font-headline-md text-headline-md text-on-surface font-bold mt-1">Rp {{ number_format($totalTerkumpul, 0, ',', '.') }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-surface-container-high text-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]">savings</span>
            </div>
        </div>
    </div>

    <!-- Filters & Table -->
    <div class="bg-surface-container-lowest rounded-xl shadow-xs border border-outline-variant/30 overflow-hidden">
        <form method="GET" action="{{ route('siswa.index') }}" class="p-space-md border-b border-outline-variant/30 flex flex-col sm:flex-row gap-space-sm items-center justify-between">
            <div class="relative w-full sm:w-80">
                <span class="material-symbols-outlined absolute left-3 top-2.5 text-on-surface-variant text-[20px] pointer-events-none">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIS, atau wali..." class="w-full h-10 pl-10 pr-4 rounded-lg bg-surface-container-low border border-outline-variant/50 text-body-md text-on-surface focus:outline-none focus:border-primary-container focus:ring-1 focus:ring-primary-container"/>
            </div>
            <div class="flex items-center gap-space-sm w-full sm:w-auto">
                <select name="status" onchange="this.form.submit()" class="h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 text-body-md text-on-surface focus:outline-none">
                    <option value="">Semua Status</option>
                    <option value="lunas" {{ request('status') === 'lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="belum_lunas" {{ request('status') === 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                </select>
                @if(request('search') || request('status'))
                    <a href="{{ route('siswa.index') }}" class="h-10 px-3 flex items-center gap-1 rounded-lg text-on-surface-variant hover:bg-surface-container-low text-label-md">
                        <span class="material-symbols-outlined text-[18px]">clear</span>
                        <span>Reset</span>
                    </a>
                @endif
            </div>
        </form>

        <!-- Responsive Table Container -->
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low/70 border-b border-outline-variant/30 font-label-md text-label-md text-on-surface-variant">
                        <th class="py-3 px-4 w-12 text-center">No</th>
                        <th class="py-3 px-4">Nama Siswa</th>
                        <th class="py-3 px-4">Kontak & Orang Tua</th>
                        <th class="py-3 px-4 text-right">Target Kas</th>
                        <th class="py-3 px-4 text-right">Terbayar</th>
                        <th class="py-3 px-4 text-right">Sisa Kas</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20">
                    @forelse($siswas as $idx => $s)
                        <tr class="hover:bg-surface-container-low/40 transition-colors">
                            <td class="py-3 px-4 text-center font-label-sm text-outline">{{ $idx + 1 }}</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-primary/10 text-primary font-bold text-xs flex items-center justify-center shrink-0">
                                        {{ $s->initials }}
                                    </div>
                                    <div class="flex flex-col min-w-0">
                                        <div class="flex items-center gap-2">
                                            <span class="font-label-lg text-label-lg text-on-surface font-semibold truncate">{{ $s->nama }}</span>
                                            <span class="font-label-sm text-[10px] px-1.5 py-0.2 rounded bg-surface-container-high text-on-surface-variant font-bold uppercase">{{ $s->jenis_kelamin }}</span>
                                        </div>
                                        <span class="font-body-sm text-[11px] text-on-surface-variant font-mono">NIS: {{ $s->nis }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex flex-col text-body-sm">
                                    <span class="text-on-surface font-medium">{{ $s->no_hp ?? '-' }}</span>
                                    <span class="text-on-surface-variant text-[11px]">{{ $s->nama_wali ?? 'Wali belum diisi' }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-right font-label-md tabular-nums text-on-surface">
                                Rp {{ number_format($s->target_kas, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-right font-label-md tabular-nums text-secondary font-semibold">
                                Rp {{ number_format($s->total_terbayar, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-right font-label-md tabular-nums {{ $s->sisa_kas > 0 ? 'text-error font-bold' : 'text-on-surface-variant' }}">
                                Rp {{ number_format($s->sisa_kas, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                @if($s->status === 'lunas')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-secondary-container/50 text-secondary font-label-sm text-[11px] font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                        Lunas
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-error-container/50 text-error font-label-sm text-[11px] font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
                                        Belum Lunas
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    @if($s->no_hp)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $s->no_hp) }}?text=Halo%20{{ urlencode($s->nama) }},%20iuran%20kas%20kelas%20XII%20IPA%202%20tercatat%20sebesar%20Rp%20{{ number_format($s->total_terbayar, 0, ',', '.') }}/{{ number_format($s->target_kas, 0, ',', '.') }}." target="_blank" class="p-1.5 rounded-lg text-secondary hover:bg-secondary-container/30 transition-colors" title="Hubungi Siswa/Wali di WA">
                                            <span class="material-symbols-outlined text-[18px]">chat</span>
                                        </a>
                                    @endif
                                    <button type="button" onclick="openEditStudentModal({{ json_encode($s) }})" class="p-1.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-surface-container transition-colors" title="Edit Data Siswa">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </button>
                                    <form action="{{ route('siswa.destroy', $s->id) }}" method="POST" onsubmit="return handleConfirmDelete(event, this, 'Hapus Data Siswa', 'Apakah Anda yakin ingin menghapus data {{ $s->nama }}? Data yang dihapus tidak dapat dikembalikan.');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-on-surface-variant hover:text-error hover:bg-error-container/30 transition-colors" title="Hapus Siswa">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-on-surface-variant">
                                Tidak ada data siswa yang sesuai pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Tambah Siswa Baru -->
<div id="modal-add-student" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs hidden">
    <div class="bg-surface-container-lowest rounded-2xl shadow-xl w-full max-w-md overflow-hidden animate-fadeIn">
        <div class="p-5 border-b border-outline-variant/30 flex items-center justify-between">
            <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">Tambah Data Siswa</h3>
            <button type="button" onclick="closeAddStudentModal()" class="p-1 rounded-lg text-on-surface-variant hover:bg-surface-container-low">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <form action="{{ route('siswa.store') }}" method="POST" class="p-5 space-y-4">
            @csrf
            <div>
                <label class="block font-label-md text-label-md text-on-surface mb-1">NIS (Nomor Induk Siswa) *</label>
                <input type="text" name="nis" required placeholder="Contoh: 89208" class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface"/>
            </div>
            <div>
                <label class="block font-label-md text-label-md text-on-surface mb-1">Nama Lengkap Siswa *</label>
                <input type="text" name="nama" required placeholder="Nama lengkap siswa" class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface"/>
            </div>
            <div>
                <label class="block font-label-md text-label-md text-on-surface mb-1">Jenis Kelamin *</label>
                <select name="jenis_kelamin" required class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface">
                    <option value="L">Laki-laki (L)</option>
                    <option value="P">Perempuan (P)</option>
                </select>
            </div>
            <div>
                <label class="block font-label-md text-label-md text-on-surface mb-1">No. WhatsApp / HP</label>
                <input type="text" name="no_hp" placeholder="0812-xxxx-xxxx" class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface"/>
            </div>
            <div>
                <label class="block font-label-md text-label-md text-on-surface mb-1">Nama Orang Tua / Wali</label>
                <input type="text" name="nama_wali" placeholder="Bpk / Ibu ..." class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface"/>
            </div>
            <div>
                <label class="block font-label-md text-label-md text-on-surface mb-1">Target Kas Bulanan (Rp)</label>
                <input type="number" name="target_kas" value="20000" min="0" class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface"/>
            </div>
            <div class="pt-3 border-t border-outline-variant/30 flex justify-end gap-2">
                <button type="button" onclick="closeAddStudentModal()" class="px-4 py-2 rounded-lg bg-surface-container text-on-surface font-label-lg hover:bg-surface-container-high transition-colors">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-primary-container text-on-primary font-label-lg hover:opacity-90 transition-all">Simpan Siswa</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Data Siswa -->
<div id="modal-edit-student" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs hidden">
    <div class="bg-surface-container-lowest rounded-2xl shadow-xl w-full max-w-md overflow-hidden animate-fadeIn">
        <div class="p-5 border-b border-outline-variant/30 flex items-center justify-between">
            <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">Edit Data Siswa</h3>
            <button type="button" onclick="closeEditStudentModal()" class="p-1 rounded-lg text-on-surface-variant hover:bg-surface-container-low">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <form id="form-edit-student" method="POST" class="p-5 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-label-md text-label-md text-on-surface mb-1">Nama Lengkap Siswa *</label>
                <input type="text" id="edit-nama" name="nama" required class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface"/>
            </div>
            <div>
                <label class="block font-label-md text-label-md text-on-surface mb-1">Jenis Kelamin *</label>
                <select id="edit-jk" name="jenis_kelamin" required class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface">
                    <option value="L">Laki-laki (L)</option>
                    <option value="P">Perempuan (P)</option>
                </select>
            </div>
            <div>
                <label class="block font-label-md text-label-md text-on-surface mb-1">No. WhatsApp / HP</label>
                <input type="text" id="edit-nohp" name="no_hp" class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface"/>
            </div>
            <div>
                <label class="block font-label-md text-label-md text-on-surface mb-1">Nama Orang Tua / Wali</label>
                <input type="text" id="edit-wali" name="nama_wali" class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface"/>
            </div>
            <div>
                <label class="block font-label-md text-label-md text-on-surface mb-1">Target Kas Bulanan (Rp)</label>
                <input type="number" id="edit-target" name="target_kas" min="0" class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface"/>
            </div>
            <div class="pt-3 border-t border-outline-variant/30 flex justify-end gap-2">
                <button type="button" onclick="closeEditStudentModal()" class="px-4 py-2 rounded-lg bg-surface-container text-on-surface font-label-lg hover:bg-surface-container-high transition-colors">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-primary-container text-on-primary font-label-lg hover:opacity-90 transition-all">Perbarui Data</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openAddStudentModal() {
    document.getElementById('modal-add-student').classList.remove('hidden');
}
function closeAddStudentModal() {
    document.getElementById('modal-add-student').classList.add('hidden');
}
function openEditStudentModal(student) {
    const form = document.getElementById('form-edit-student');
    form.action = "{{ route('siswa.index') }}/" + student.id;
    document.getElementById('edit-nama').value = student.nama;
    document.getElementById('edit-jk').value = student.jenis_kelamin;
    document.getElementById('edit-nohp').value = student.no_hp || '';
    document.getElementById('edit-wali').value = student.nama_wali || '';
    document.getElementById('edit-target').value = student.target_kas;
    document.getElementById('modal-edit-student').classList.remove('hidden');
}
function closeEditStudentModal() {
    document.getElementById('modal-edit-student').classList.add('hidden');
}
</script>
@endpush
