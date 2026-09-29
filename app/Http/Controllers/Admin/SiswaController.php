<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhere('nama_wali', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && in_array($request->status, ['lunas', 'belum_lunas'])) {
            $query->where('status', $request->status);
        }

        $siswas = $query->orderBy('nama', 'asc')->get();

        $totalSiswa = Siswa::count();
        $totalLunas = Siswa::where('status', 'lunas')->count();
        $totalBelumLunas = Siswa::where('status', 'belum_lunas')->count();
        $totalTerkumpul = (int) Siswa::sum('total_terbayar');
        $targetTotal = (int) Siswa::sum('target_kas');

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'siswas' => $siswas,
                    'totalSiswa' => $totalSiswa,
                    'totalLunas' => $totalLunas,
                    'totalBelumLunas' => $totalBelumLunas,
                    'totalTerkumpul' => $totalTerkumpul,
                ]
            ]);
        }

        return view('admin.siswa.index', compact(
            'siswas',
            'totalSiswa',
            'totalLunas',
            'totalBelumLunas',
            'totalTerkumpul',
            'targetTotal'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|unique:siswas,nis',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'nullable|string',
            'nama_wali' => 'nullable|string',
            'target_kas' => 'nullable|integer|min:0',
        ]);

        $validated['target_kas'] = $validated['target_kas'] ?? 80000;
        $validated['total_terbayar'] = 0;
        $validated['status'] = 'belum_lunas';

        $siswa = Siswa::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data siswa berhasil ditambahkan!',
                'data' => $siswa
            ], 201);
        }

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'nullable|string',
            'nama_wali' => 'nullable|string',
            'target_kas' => 'nullable|integer|min:0',
        ]);

        $siswa->update($validated);

        // Recalculate status
        $siswa->status = $siswa->total_terbayar >= $siswa->target_kas ? 'lunas' : 'belum_lunas';
        $siswa->save();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data siswa berhasil diperbarui!',
                'data' => $siswa
            ]);
        }

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy(Request $request, Siswa $siswa)
    {
        $nama = $siswa->nama;
        $siswa->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => "Data siswa {$nama} berhasil dihapus!"
            ]);
        }

        return redirect()->route('admin.siswa.index')->with('success', "Data siswa {$nama} berhasil dihapus!");
    }
}
