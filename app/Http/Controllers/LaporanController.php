<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->get('bulan', 'Oktober');
        $tahun = (int) $request->get('tahun', 2024);

        $totalPemasukan = (int) Pemasukan::sum('nominal');
        $totalPengeluaran = (int) Pengeluaran::sum('nominal');
        $saldoKas = $totalPemasukan - $totalPengeluaran;

        $pemasukans = Pemasukan::orderBy('tanggal', 'asc')->get();
        $pengeluarans = Pengeluaran::orderBy('tanggal', 'asc')->get();

        $totalSiswa = Siswa::count();
        $siswaLunas = Siswa::where('status', 'lunas')->count();
        $persenLunas = $totalSiswa > 0 ? round(($siswaLunas / $totalSiswa) * 100) : 0;

        // Grouping for expense category breakdown
        $kategoriPengeluaran = Pengeluaran::selectRaw('kategori, sum(nominal) as total')
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'totalPemasukan' => $totalPemasukan,
                    'totalPengeluaran' => $totalPengeluaran,
                    'saldoKas' => $saldoKas,
                    'pemasukans' => $pemasukans,
                    'pengeluarans' => $pengeluarans,
                    'kategoriPengeluaran' => $kategoriPengeluaran,
                ]
            ]);
        }

        return view('laporan.index', compact(
            'bulan',
            'tahun',
            'totalPemasukan',
            'totalPengeluaran',
            'saldoKas',
            'pemasukans',
            'pengeluarans',
            'totalSiswa',
            'siswaLunas',
            'persenLunas',
            'kategoriPengeluaran'
        ));
    }
}
