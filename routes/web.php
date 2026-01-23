<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\AbsensiController;
use App\Http\Controllers\Dashboard\IzinController;
use App\Http\Controllers\Dashboard\LaporanController;
use App\Http\Controllers\Dashboard\PeminjamanController;
use App\Http\Controllers\Dashboard\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'index')->name('login');
        Route::post('/login', 'login')->name('login.post');
    });
    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'index')->name('register');
        Route::post('/register', 'register')->name('register.post');
    });
});

Route::middleware('auth')->group(function () {
    Route::prefix('/dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::controller(AbsensiController::class)->group(function () {
            Route::get('/absensi-masuk', 'masuk')->name('absensi.masuk');
            Route::post('/absensi-masuk', 'masukStore')->name('absensi.masuk.store');
            Route::get('/absensi-keluar', 'keluar')->name('absensi.keluar');
            Route::post('/absensi-keluar', 'keluarStore')->name('absensi.keluar.store');
        });

        Route::controller(IzinController::class)->group(function () {
            Route::get('/izin', 'index')->name('izin.index');
        });

        Route::controller(ProfileController::class)->group(function () {
            Route::get('/profile', 'index')->name('profile.index');
            Route::put('/profile/update', 'update')->name('profile.update');
            Route::put('/profile/change-password', 'changePassword')->name('profile.change-password');
            Route::put('/profile/avatar', 'updateAvatar')->name('profile.avatar');
        });
    });

    Route::controller(TodoController::class)->group(function () {
        Route::get('/todo', 'index')->name('todo.index');
        Route::post('/todo', 'store')->name('todo.store');
        Route::get('/todo/create', 'create')->name('todo.create');
        Route::get('/todo/{todo}/edit', 'edit')->name('todo.edit');
        Route::put('/todo/{todo}', 'update')->name('todo.update');
        Route::delete('/todo/{todo}', 'destroy')->name('todo.destroy');
    });

    Route::controller(PeminjamanController::class)->group(function () {
        Route::get('/peminjaman', 'index')->name('peminjaman.index');
        Route::get('/peminjaman/create', 'create')->name('peminjaman.create');
        Route::post('/peminjaman', 'store')->name('peminjaman.store');
        Route::get('/peminjaman/{id}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
        Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
        Route::put('/peminjaman/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
    });

    Route::controller(LaporanController::class)->group(function () {
        Route::get('/laporan', 'index')->name('laporan.index');
    });

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
