<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemasukan;
use Illuminate\Http\Request;

class PemasukanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemasukan::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('deskripsi', 'like', "%{$search}%")
                  ->orWhere('kode_transaksi', 'like', "%{$search}%")
                  ->orWhere('sumber', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori') && $request->kategori !== 'Semua') {
            $query->where('kategori', $request->kategori);
        }

        $pemasukans = $query->orderBy('tanggal', 'desc')->get();

        $totalPemasukan = (int) Pemasukan::sum('nominal');
        $totalIuran = (int) Pemasukan::where('kategori', 'Iuran Kas')->sum('nominal');
        $totalDonasi = (int) Pemasukan::where('kategori', 'Donasi')->sum('nominal');
        $totalLainnya = (int) Pemasukan::whereNotIn('kategori', ['Iuran Kas', 'Donasi'])->sum('nominal');

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'pemasukans' => $pemasukans,
                    'totalPemasukan' => $totalPemasukan,
                    'totalIuran' => $totalIuran,
                    'totalDonasi' => $totalDonasi,
                    'totalLainnya' => $totalLainnya,
                ]
            ]);
        }

        return view('admin.pemasukan.index', compact(
            'pemasukans',
            'totalPemasukan',
            'totalIuran',
            'totalDonasi',
            'totalLainnya'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required|string',
            'deskripsi' => 'required|string|max:255',
            'nominal' => 'required|integer|min:1000',
            'tanggal' => 'required|date',
            'sumber' => 'required|string',
            'penanggung_jawab' => 'nullable|string',
        ]);

        $count = Pemasukan::count() + 1;
        $validated['kode_transaksi'] = sprintf('IN-2410-%02d', $count);
        $validated['penanggung_jawab'] = $validated['penanggung_jawab'] ?? 'Salsabila Putri';

        $pemasukan = Pemasukan::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Catatan pemasukan kas berhasil ditambahkan!',
                'data' => $pemasukan
            ], 201);
        }

        return redirect()->route('admin.pemasukan.index')->with('success', 'Catatan pemasukan kas berhasil ditambahkan!');
    }

    public function destroy(Request $request, Pemasukan $pemasukan)
    {
        $pemasukan->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Catatan pemasukan berhasil dihapus!'
            ]);
        }

        return redirect()->route('admin.pemasukan.index')->with('success', 'Catatan pemasukan berhasil dihapus!');
    }
}
