<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Pembayaran;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalPemasukan = (int) Pemasukan::sum('nominal');
        $totalPengeluaran = (int) Pengeluaran::sum('nominal');
        $saldoKas = $totalPemasukan - $totalPengeluaran;

        $totalSiswa = Siswa::count();
        $siswaLunas = Siswa::where('status', 'lunas')->count();
        $persenLunas = $totalSiswa > 0 ? round(($siswaLunas / $totalSiswa) * 100) : 0;

        // Target kas bulan ini
        $targetBulanIni = (int) Siswa::sum('target_kas') ?: ($totalSiswa * 20000);
        $persenTarget = $targetBulanIni > 0 ? round(($totalPemasukan / $targetBulanIni) * 100) : 0;

        // Recent transactions combined
        $recentIncomes = Pemasukan::latest('tanggal')->take(3)->get()->map(function ($item) {
            return [
                'type' => 'in',
                'kode' => $item->kode_transaksi,
                'judul' => $item->judul ?? $item->deskripsi ?? 'Pemasukan Kas',
                'kategori' => $item->kategori,
                'tanggal' => \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y'),
                'nominal' => $item->nominal,
                'pj' => $item->sumber ?? 'Kas Kelas',
            ];
        });

        $recentExpenses = Pengeluaran::latest('tanggal')->take(3)->get()->map(function ($item) {
            return [
                'type' => 'out',
                'kode' => $item->kode_transaksi,
                'judul' => $item->judul ?? $item->deskripsi ?? 'Pengeluaran Kas',
                'kategori' => $item->kategori,
                'tanggal' => \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y'),
                'nominal' => $item->nominal,
                'pj' => $item->penanggung_jawab ?? 'Bendahara',
            ];
        });

        // Siswa yang belum lunas (arrears)
        $siswaMenunggak = Siswa::where('status', 'belum_lunas')
            ->orderBy('total_terbayar', 'asc')
            ->get();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'saldoKas' => $saldoKas,
                    'totalPemasukan' => $totalPemasukan,
                    'totalPengeluaran' => $totalPengeluaran,
                    'totalSiswa' => $totalSiswa,
                    'siswaLunas' => $siswaLunas,
                    'persenLunas' => $persenLunas,
                    'recentIncomes' => $recentIncomes,
                    'recentExpenses' => $recentExpenses,
                    'siswaMenunggak' => $siswaMenunggak,
                ]
            ]);
        }

        return view('admin.dashboard', compact(
            'saldoKas',
            'totalPemasukan',
            'totalPengeluaran',
            'totalSiswa',
            'siswaLunas',
            'persenLunas',
            'targetBulanIni',
            'persenTarget',
            'recentIncomes',
            'recentExpenses',
            'siswaMenunggak'
        ));
    }
}
