<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Pembayaran;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Find matching student record by user name or session/query nis
        $nis = $request->get('nis');
        $siswa = null;

        if ($nis) {
            $siswa = Siswa::with(['pembayarans' => function($q) {
                $q->orderBy('tanggal_bayar', 'desc');
            }])->where('nis', $nis)->first();
        }

        if (!$siswa && $user) {
            $siswa = Siswa::with(['pembayarans' => function($q) {
                $q->orderBy('tanggal_bayar', 'desc');
            }])->where('nama', $user->name)
               ->orWhere('nama', 'LIKE', '%' . explode(' ', $user->name)[0] . '%')
               ->first();
        }

        // Fallback to Ahmad Fauzi (NIS: 89201) if not found
        if (!$siswa) {
            $siswa = Siswa::with(['pembayarans' => function($q) {
                $q->orderBy('tanggal_bayar', 'desc');
            }])->where('nis', '89201')->first() ?? Siswa::with('pembayarans')->first();
        }

        $allStudents = Siswa::with('pembayarans')->orderBy('nama')->get();
        $totalSiswa = $allStudents->count();
        $siswaLunasCount = $allStudents->where('status', 'lunas')->count();
        $siswaNunggakCount = $totalSiswa - $siswaLunasCount;
        $totalTunggakanKelas = $allStudents->sum(fn($st) => $st->sisa_kas);
        $partisipasiPersen = $totalSiswa > 0 ? round(($siswaLunasCount / $totalSiswa) * 100) : 0;

        $totalPemasukan = (int) Pemasukan::sum('nominal');
        $totalPengeluaran = (int) Pengeluaran::sum('nominal');
        $saldoKas = $totalPemasukan - $totalPengeluaran;

        $pengeluarans = Pengeluaran::orderBy('tanggal', 'desc')->take(6)->get();

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

        return view('siswa.dashboard', compact(
            'siswa',
            'allStudents',
            'saldoKas',
            'totalPemasukan',
            'totalPengeluaran',
            'totalSiswa',
            'siswaLunasCount',
            'siswaNunggakCount',
            'totalTunggakanKelas',
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
