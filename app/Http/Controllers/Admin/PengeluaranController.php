<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengeluaran::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('deskripsi', 'like', "%{$search}%")
                  ->orWhere('kode_transaksi', 'like', "%{$search}%")
                  ->orWhere('toko_vendor', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori') && $request->kategori !== 'Semua') {
            $query->where('kategori', $request->kategori);
        }

        $pengeluarans = $query->orderBy('tanggal', 'desc')->get();

        $totalPengeluaran = (int) Pengeluaran::sum('nominal');
        $totalPemasukan = (int) Pemasukan::sum('nominal');
        $sisaSaldo = $totalPemasukan - $totalPengeluaran;
        $totalTransaksi = Pengeluaran::count();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'pengeluarans' => $pengeluarans,
                    'totalPengeluaran' => $totalPengeluaran,
                    'sisaSaldo' => $sisaSaldo,
                    'totalTransaksi' => $totalTransaksi,
                ]
            ]);
        }

        return view('admin.pengeluaran.index', compact(
            'pengeluarans',
            'totalPengeluaran',
            'sisaSaldo',
            'totalTransaksi'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required|string',
            'deskripsi' => 'required|string|max:255',
            'nominal' => 'required|integer|min:1000',
            'tanggal' => 'required|date',
            'toko_vendor' => 'required|string',
            'nomor_nota' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        // Validate that cash balance is sufficient
        $totalPemasukan = (int) Pemasukan::sum('nominal');
        $totalPengeluaran = (int) Pengeluaran::sum('nominal');
        $sisaSaldo = $totalPemasukan - $totalPengeluaran;

        if ($validated['nominal'] > $sisaSaldo) {
            $msg = "Saldo kas tidak mencukupi! Sisa kas: Rp " . number_format($sisaSaldo, 0, ',', '.');
            if ($request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => $msg], 422);
            }
            return redirect()->back()->withErrors(['nominal' => $msg])->withInput();
        }

        $count = Pengeluaran::count() + 1;
        $validated['kode_transaksi'] = sprintf('OUT-2410-%02d', $count);
        $validated['status_verifikasi'] = 'terverifikasi';
        $validated['penanggung_jawab'] = 'Salsabila Putri';

        $pengeluaran = Pengeluaran::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Catatan pengeluaran kas berhasil disimpan!',
                'data' => $pengeluaran
            ], 201);
        }

        return redirect()->route('admin.pengeluaran.index')->with('success', 'Catatan pengeluaran kas berhasil disimpan!');
    }

    public function destroy(Request $request, Pengeluaran $pengeluaran)
    {
        $pengeluaran->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Catatan pengeluaran berhasil dihapus!'
            ]);
        }

        return redirect()->route('admin.pengeluaran.index')->with('success', 'Catatan pengeluaran berhasil dihapus!');
    }
}
