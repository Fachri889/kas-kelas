<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
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

        if (!$siswa) {
            $siswa = Siswa::with(['pembayarans' => function($q) {
                $q->orderBy('tanggal_bayar', 'desc');
            }])->where('nis', '89201')->first() ?? Siswa::with('pembayarans')->first();
        }

        $allStudents = Siswa::select('id', 'nis', 'nama', 'status')->orderBy('nama')->get();
        $pembayarans = $siswa ? $siswa->pembayarans : collect();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'siswa' => $siswa,
                    'pembayarans' => $pembayarans,
                ]
            ]);
        }

        return view('siswa.pembayaran', compact('siswa', 'pembayarans', 'allStudents'));
    }
}
