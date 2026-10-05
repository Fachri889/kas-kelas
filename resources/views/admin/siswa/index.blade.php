@extends('layouts.admin')

@section('title', 'Data Siswa & Kas')

@section('content')
    <div class="flex flex-col w-full max-w-5xl gap-space-lg">
        <!-- Header Section -->
        <div
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-space-md bg-surface-container-lowest p-space-lg rounded-xl shadow-xs border border-outline-variant/30">
            <div>
                <div class="flex items-center gap-space-xs">
                    <h1 class="font-headline-lg text-headline-lg text-on-surface font-bold">Data Siswa & Kepatuhan Kas</h1>
                    <span class="px-2 py-0.5 rounded-full bg-primary-fixed text-primary font-label-sm font-semibold">Kelas
                        XII IPA 2</span>
                </div>
                <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                    Kelola status pembayaran, data kontak orang tua, dan mutasi iuran per siswa.
                </p>
            </div>
            <div class="flex items-center gap-space-sm flex-wrap">
                <button type="button" onclick="openAddStudentModal()"
                    class="flex items-center gap-2 px-space-md py-2.5 rounded-lg bg-primary-container text-on-primary font-label-lg text-label-lg shadow-sm hover:opacity-90 transition-all font-semibold">
                    <span class="material-symbols-outlined text-[20px]">person_add</span>
                    <span>Tambah Siswa</span>
                </button>
                <a href="{{ route('admin.pembayaran.index') }}"
                    class="flex items-center gap-2 px-space-md py-2.5 rounded-lg bg-surface-container text-on-surface font-label-lg text-label-lg hover:bg-surface-container-high transition-colors font-medium">
                    <span class="material-symbols-outlined text-[20px]">payments</span>
                    <span>Input Pembayaran</span>
                </a>
            </div>
        </div>

        <!-- Summary Metrics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
            <div
                class="bg-surface-container-lowest p-4 rounded-xl shadow-xs border border-outline-variant/30 flex items-center justify-between">
                <div>
                    <span class="font-label-md text-label-md text-on-surface-variant font-medium">Total Siswa</span>
                    <p class="font-headline-md text-headline-md text-on-surface font-bold mt-1">{{ $totalSiswa }} Anak</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">groups</span>
                </div>
            </div>
            <div
                class="bg-surface-container-lowest p-4 rounded-xl shadow-xs border border-outline-variant/30 flex items-center justify-between">
                <div>
                    <span class="font-label-md text-label-md text-on-surface-variant font-medium">Siswa Lunas</span>
                    <p class="font-headline-md text-headline-md text-secondary font-bold mt-1">{{ $totalLunas }} Siswa</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-secondary-fixed/40 text-secondary flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">check_circle</span>
                </div>
            </div>
            <div
                class="bg-surface-container-lowest p-4 rounded-xl shadow-xs border border-outline-variant/30 flex items-center justify-between">
                <div>
                    <span class="font-label-md text-label-md text-on-surface-variant font-medium">Belum Lunas</span>
                    <p class="font-headline-md text-headline-md text-error font-bold mt-1">{{ $totalBelumLunas }} Siswa</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-error-container/40 text-error flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">pending</span>
                </div>
            </div>
            <div
                class="bg-surface-container-lowest p-4 rounded-xl shadow-xs border border-outline-variant/30 flex items-center justify-between">
                <div>
                    <span class="font-label-md text-label-md text-on-surface-variant font-medium">Total Terkumpul</span>
                    <p class="font-headline-md text-headline-md text-primary font-bold mt-1">Rp
                        {{ number_format($totalTerkumpul, 0, ',', '.') }}
                    </p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-primary-fixed text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">savings</span>
                </div>
            </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <div
            class="bg-surface-container-lowest p-4 rounded-xl shadow-xs border border-outline-variant/30 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <form method="GET" action="{{ route('admin.siswa.index') }}" class="flex-1 flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <span
                        class="material-symbols-outlined absolute left-3 top-2.5 text-on-surface-variant text-[20px] pointer-events-none">search</span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama, NIS, atau wali siswa..."
                        class="w-full h-10 pl-10 pr-4 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface" />
                </div>
                <select name="status" onchange="this.form.submit()"
                    class="h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 text-body-md text-on-surface focus:outline-none focus:border-primary-container">
                    <option value="">Semua Status</option>
                    <option value="lunas" {{ request('status') === 'lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="belum_lunas" {{ request('status') === 'belum_lunas' ? 'selected' : '' }}>Belum Lunas
                    </option>
                </select>
                <button type="submit"
                    class="h-10 px-4 rounded-lg bg-surface-container text-on-surface font-label-md hover:bg-surface-container-high transition-colors font-semibold">Filter</button>
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.siswa.index') }}"
                        class="h-10 px-3 rounded-lg border border-outline-variant flex items-center justify-center text-outline hover:text-on-surface transition-colors"
                        title="Reset Filter">
                        <span class="material-symbols-outlined text-[18px]">clear</span>
                    </a>
                @endif
            </form>
        </div>

        <!-- Data Table -->
        <div class="bg-surface-container-lowest rounded-xl shadow-xs border border-outline-variant/30 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-surface-container-low text-on-surface-variant font-label-md uppercase tracking-wider border-b border-outline-variant/30">
                            <th class="py-3 px-4 w-[28%] text-left">Siswa</th>
                            <th class="py-3 px-4 w-[18%] text-left">Target Kas</th>
                            <th class="py-3 px-4 w-[18%] text-left">Terbayar</th>
                            <th class="py-3 px-4 w-[24%] text-center">Status</th>
                            <th class="py-3 px-4 w-[12%] text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/15 font-body-md text-body-md">
                        @forelse($siswas as $s)
                            <tr class="hover:bg-surface-container-low/50 transition-colors">
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs shrink-0">
                                            {{ $s->initials }}
                                        </div>
                                        <div>
                                            <span
                                                class="font-label-lg text-on-surface block font-semibold">{{ $s->nama }}</span>
                                                <span
                                                class="font-body-sm text-outline">{{ $s->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-left font-medium tabular-nums">Rp
                                    {{ number_format($s->target_kas, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4 text-left font-bold text-secondary tabular-nums">Rp
                                    {{ number_format($s->total_terbayar, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    @if($s->status === 'lunas')
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-secondary-fixed/40 text-secondary font-label-sm font-semibold">
                                            <span class="material-symbols-outlined text-[14px]">check</span> Lunas
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-error-container/40 text-error font-label-sm font-semibold">
                                            <span class="material-symbols-outlined text-[14px]">pending</span> Kurang Rp
                                            {{ number_format($s->sisa_kas, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <button type="button" onclick="openEditStudentModal({{ json_encode($s) }})"
                                            class="p-1.5 rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors"
                                            title="Edit Data Siswa">
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </button>
                                        <form action="{{ route('admin.siswa.destroy', $s->id) }}" method="POST"
                                            onsubmit="return confirmAdminDelete(event, this, 'Hapus Data Siswa', 'Apakah Anda yakin ingin menghapus data siswa ini? Seluruh mutasi & iuran siswa akan terhapus permanen.', '{{ addslashes($s->nama) }}');"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-1.5 rounded-lg text-error hover:bg-error-container/40 transition-colors"
                                                title="Hapus Siswa">
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-outline">Tidak ada data siswa yang cocok.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal: Tambah Data Siswa -->
    <div id="modal-add-student"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs hidden">
        <div class="bg-surface-container-lowest rounded-2xl shadow-xl w-full max-w-md overflow-hidden animate-fadeIn">
            <div class="p-5 border-b border-outline-variant/30 flex items-center justify-between">
                <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">Tambah Data Siswa Baru</h3>
                <button type="button" onclick="closeAddStudentModal()"
                    class="p-1 rounded-lg text-on-surface-variant hover:bg-surface-container-low">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>
            <form action="{{ route('admin.siswa.store') }}" method="POST" class="p-5 space-y-4">
                @csrf
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1 font-medium">Nomor Induk Siswa
                        (NIS) *</label>
                    <input type="text" name="nis" required placeholder="Contoh: 89208"
                        class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface" />
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1 font-medium">Nama Lengkap Siswa
                        *</label>
                    <input type="text" name="nama" required placeholder="Nama lengkap siswa"
                        class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface" />
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1 font-medium">Jenis Kelamin
                        *</label>
                    <select name="jenis_kelamin" required
                        class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface">
                        <option value="L">Laki-laki (L)</option>
                        <option value="P">Perempuan (P)</option>
                    </select>
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1 font-medium">No. WhatsApp /
                        HP</label>
                    <input type="text" name="no_hp" placeholder="0812-xxxx-xxxx"
                        class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface" />
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1 font-medium">Nama Orang Tua /
                        Wali</label>
                    <input type="text" name="nama_wali" placeholder="Bpk / Ibu ..."
                        class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface" />
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1 font-medium">Target Kas Bulanan
                        (Rp)</label>
                    <input type="number" name="target_kas" value="20000" min="0"
                        class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface" />
                </div>
                <div class="pt-3 border-t border-outline-variant/30 flex justify-end gap-2">
                    <button type="button" onclick="closeAddStudentModal()"
                        class="px-4 py-2 rounded-lg bg-surface-container text-on-surface font-label-lg hover:bg-surface-container-high transition-colors font-medium">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-primary-container text-on-primary font-label-lg hover:opacity-90 transition-all font-semibold">Simpan
                        Siswa</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Edit Data Siswa -->
    <div id="modal-edit-student"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs hidden">
        <div class="bg-surface-container-lowest rounded-2xl shadow-xl w-full max-w-md overflow-hidden animate-fadeIn">
            <div class="p-5 border-b border-outline-variant/30 flex items-center justify-between">
                <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">Edit Data Siswa</h3>
                <button type="button" onclick="closeEditStudentModal()"
                    class="p-1 rounded-lg text-on-surface-variant hover:bg-surface-container-low">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>
            <form id="form-edit-student" method="POST" class="p-5 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1 font-medium">Nama Lengkap Siswa
                        *</label>
                    <input type="text" id="edit-nama" name="nama" required
                        class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface" />
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1 font-medium">Jenis Kelamin
                        *</label>
                    <select id="edit-jk" name="jenis_kelamin" required
                        class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface">
                        <option value="L">Laki-laki (L)</option>
                        <option value="P">Perempuan (P)</option>
                    </select>
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1 font-medium">No. WhatsApp /
                        HP</label>
                    <input type="text" id="edit-nohp" name="no_hp"
                        class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface" />
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1 font-medium">Nama Orang Tua /
                        Wali</label>
                    <input type="text" id="edit-wali" name="nama_wali"
                        class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface" />
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1 font-medium">Target Kas Bulanan
                        (Rp)</label>
                    <input type="number" id="edit-target" name="target_kas" min="0"
                        class="w-full h-10 px-3 rounded-lg bg-surface-container-low border border-outline-variant/50 focus:outline-none focus:border-primary-container text-body-md text-on-surface" />
                </div>
                <div class="pt-3 border-t border-outline-variant/30 flex justify-end gap-2">
                    <button type="button" onclick="closeEditStudentModal()"
                        class="px-4 py-2 rounded-lg bg-surface-container text-on-surface font-label-lg hover:bg-surface-container-high transition-colors font-medium">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-primary-container text-on-primary font-label-lg hover:opacity-90 transition-all font-semibold">Perbarui
                        Data</button>
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
            form.action = "{{ route('admin.siswa.index') }}/" + student.id;
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