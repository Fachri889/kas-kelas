<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Pembayaran;
use App\Models\Pemasukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->get('bulan', 'Oktober');
        $tahun = (int) $request->get('tahun', 2024);

        $siswas = Siswa::with(['pembayarans' => function ($q) use ($bulan, $tahun) {
            $q->where('bulan', $bulan)->where('tahun', $tahun);
        }])->orderBy('nama', 'asc')->get();

        $recentPayments = Pembayaran::with('siswa')
            ->latest('tanggal_bayar')
            ->take(10)
            ->get();

        $totalTerkumpul = (int) Pembayaran::where('bulan', $bulan)->where('tahun', $tahun)->sum('nominal');

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'siswas' => $siswas,
                    'recentPayments' => $recentPayments,
                    'totalTerkumpul' => $totalTerkumpul,
                ]
            ]);
        }

        return view('admin.pembayaran.index', compact('siswas', 'recentPayments', 'bulan', 'tahun', 'totalTerkumpul'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'minggu_ke' => 'required|integer|min:1|max:5',
            'bulan' => 'required|string',
            'tahun' => 'required|integer',
            'nominal' => 'required|integer|min:1000',
            'tanggal_bayar' => 'required|date',
            'metode_pembayaran' => 'required|in:tunai,transfer,qris',
            'catatan' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($validated, $request) {
            $siswa = Siswa::findOrFail($validated['siswa_id']);
            $count = Pembayaran::count() + 1;
            $kode = sprintf('TRX-%02d%02d-%02d-%s', substr($validated['tahun'], -2), 10, $count, $siswa->nis);

            $pembayaran = Pembayaran::create([
                'kode_transaksi' => $kode,
                'siswa_id' => $siswa->id,
                'minggu_ke' => $validated['minggu_ke'],
                'bulan' => $validated['bulan'],
                'tahun' => $validated['tahun'],
                'nominal' => $validated['nominal'],
                'tanggal_bayar' => $validated['tanggal_bayar'],
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'status' => 'lunas',
                'catatan' => $validated['catatan'] ?? "Pembayaran kas Minggu {$validated['minggu_ke']} {$validated['bulan']}",
            ]);

            // Update student's total paid and status
            $siswa->total_terbayar += $validated['nominal'];
            $siswa->status = $siswa->total_terbayar >= $siswa->target_kas ? 'lunas' : 'belum_lunas';
            $siswa->save();

            // Also record in Pemasukan table for bookkeeping
            Pemasukan::create([
                'kode_transaksi' => 'IN-' . substr($kode, 4),
                'kategori' => 'Iuran Kas',
                'deskripsi' => "Iuran Kas M{$validated['minggu_ke']} {$siswa->nama}",
                'nominal' => $validated['nominal'],
                'tanggal' => $validated['tanggal_bayar'],
                'sumber' => "Siswa: {$siswa->nama} ({$siswa->nis})",
                'penanggung_jawab' => 'Salsabila Putri',
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => "Pembayaran sebesar Rp " . number_format($validated['nominal'], 0, ',', '.') . " berhasil dicatat!",
                    'data' => $pembayaran
                ], 201);
            }

            return redirect()->route('admin.pembayaran.index')->with('success', "Pembayaran untuk {$siswa->nama} berhasil dicatat!");
        });
    }
}
