<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PortalSiswaController extends Controller
{
    public function index(Request $request)
    {
        // Default student Ahmad Fauzi (NIS: 89201) or lookup by NIS in query
        $nis = $request->get('nis', '89201');
        $siswa = Siswa::with(['pembayarans' => function($q) {
            $q->orderBy('tanggal_bayar', 'desc');
        }])->where('nis', $nis)->first();

        if (!$siswa) {
            $siswa = Siswa::with(['pembayarans' => function($q) {
                $q->orderBy('tanggal_bayar', 'desc');
            }])->first();
        }

        $allStudents = Siswa::select('id', 'nis', 'nama', 'status', 'total_terbayar')->orderBy('nama')->get();
        $totalSiswa = $allStudents->count();
        $siswaLunasCount = $allStudents->where('status', 'lunas')->count();
        $partisipasiPersen = $totalSiswa > 0 ? round(($siswaLunasCount / $totalSiswa) * 100) : 0;

        $totalPemasukan = \App\Models\Pemasukan::sum('jumlah');
        $totalPengeluaran = \App\Models\Pengeluaran::sum('jumlah');
        $saldoKas = $totalPemasukan - $totalPengeluaran;

        $pengeluarans = \App\Models\Pengeluaran::orderBy('tanggal', 'desc')->take(6)->get();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'siswa' => $siswa,
                    'pembayarans' => $siswa ? $siswa->pembayarans : [],
                    'saldo_kas' => $saldoKas,
                    'total_pemasukan' => $totalPemasukan,
                    'total_pengeluaran' => $totalPengeluaran,
                    'partisipasi_persen' => $partisipasiPersen,
                ]
            ]);
        }

        return view('portal.index', compact(
            'siswa',
            'allStudents',
            'saldoKas',
            'totalPemasukan',
            'totalPengeluaran',
            'totalSiswa',
            'siswaLunasCount',
            'partisipasiPersen',
            'pengeluarans'
        ));
    }

    public function check(Request $request)
    {
        $request->validate(['nis' => 'required|string']);
        $siswa = Siswa::with('pembayarans')->where('nis', $request->nis)->first();

        if (!$siswa) {
            return response()->json(['status' => 'error', 'message' => 'Siswa dengan NIS tersebut tidak ditemukan.'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'nama' => $siswa->nama,
                'nis' => $siswa->nis,
                'kelas' => $siswa->kelas,
                'target_kas' => $siswa->target_kas,
                'total_terbayar' => $siswa->total_terbayar,
                'sisa_kas' => $siswa->sisa_kas,
                'status' => $siswa->status,
                'pembayarans' => $siswa->pembayarans,
            ]
        ]);
    }
}
