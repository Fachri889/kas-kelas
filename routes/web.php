<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SiswaController as AdminSiswaController;
use App\Http\Controllers\Admin\PembayaranController as AdminPembayaranController;
use App\Http\Controllers\Admin\PemasukanController as AdminPemasukanController;
use App\Http\Controllers\Admin\PengeluaranController as AdminPengeluaranController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\PembayaranController as SiswaPembayaranController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| Routes are cleanly separated into Guest/Auth, Admin, and Siswa groups.
|
*/

// 1. Root & Guest Entry
Route::get('/', function () {
    if (auth()->check() && auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('siswa.dashboard');
});

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 2. Admin Panel Routes (Protected by auth & role:admin)
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Siswa Management
        Route::prefix('siswa')->name('siswa.')->group(function () {
            Route::get('/', [AdminSiswaController::class, 'index'])->name('index');
            Route::post('/', [AdminSiswaController::class, 'store'])->name('store');
            Route::put('/{siswa}', [AdminSiswaController::class, 'update'])->name('update');
            Route::delete('/{siswa}', [AdminSiswaController::class, 'destroy'])->name('destroy');
        });

        // Pembayaran Kas
        Route::prefix('pembayaran')->name('pembayaran.')->group(function () {
            Route::get('/', [AdminPembayaranController::class, 'index'])->name('index');
            Route::post('/', [AdminPembayaranController::class, 'store'])->name('store');
        });

        // Pemasukan
        Route::prefix('pemasukan')->name('pemasukan.')->group(function () {
            Route::get('/', [AdminPemasukanController::class, 'index'])->name('index');
            Route::post('/', [AdminPemasukanController::class, 'store'])->name('store');
            Route::delete('/{pemasukan}', [AdminPemasukanController::class, 'destroy'])->name('destroy');
        });

        // Pengeluaran
        Route::prefix('pengeluaran')->name('pengeluaran.')->group(function () {
            Route::get('/', [AdminPengeluaranController::class, 'index'])->name('index');
            Route::post('/', [AdminPengeluaranController::class, 'store'])->name('store');
            Route::delete('/{pengeluaran}', [AdminPengeluaranController::class, 'destroy'])->name('destroy');
        });

        // Laporan Keuangan
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/', [AdminLaporanController::class, 'index'])->name('index');
        });
    });

// 3. Siswa / Student Portal Routes (Public transparency for students and parents)
Route::prefix('siswa')
    ->name('siswa.')
    ->group(function () {
        Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
        Route::get('/pembayaran', [SiswaPembayaranController::class, 'index'])->name('pembayaran.index');
        Route::post('/check', [SiswaDashboardController::class, 'check'])->name('check');
    });

// 4. Backward Compatibility Aliases & Friendly Named Redirects
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard');

Route::get('/portal', function () {
    return redirect()->route('siswa.dashboard');
})->name('portal.index');

Route::post('/portal/check', [SiswaDashboardController::class, 'check'])->name('portal.check');

Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
});

Route::get('/dashboard.html', function () { return redirect()->route('admin.dashboard'); });
Route::get('/admin.html', function () { return redirect()->route('admin.dashboard'); });
Route::get('/siswa.html', function () { return redirect()->route('admin.siswa.index'); });
Route::get('/pembayaran.html', function () { return redirect()->route('admin.pembayaran.index'); });
Route::get('/pemasukan.html', function () { return redirect()->route('admin.pemasukan.index'); });
Route::get('/pengeluaran.html', function () { return redirect()->route('admin.pengeluaran.index'); });
Route::get('/laporan.html', function () { return redirect()->route('admin.laporan.index'); });
Route::get('/portal.html', function () { return redirect()->route('siswa.dashboard'); });
Route::get('/login.html', function () { return redirect()->route('login'); });
