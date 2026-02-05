<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\AbsensiController;
use App\Http\Controllers\Dashboard\DivisionController;
use App\Http\Controllers\Dashboard\EmployeeManagementController;
use App\Http\Controllers\Dashboard\IzinController;
use App\Http\Controllers\Dashboard\LaporanController;
use App\Http\Controllers\Dashboard\LoanController;
use App\Http\Controllers\Dashboard\TodoController;
use App\Http\Controllers\Dashboard\LogController;
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

        Route::controller(TodoController::class)->group(function () {
            Route::get('/todo', 'index')->name('todo.index');
            Route::post('/todo', 'store')->name('todo.store');
            Route::put('/todo/{todo}', 'update')->name('todo.update');
            Route::delete('/todo/{todo}', 'destroy')->name('todo.destroy');
            Route::patch('/todo/subtask/{subtask}/toggle', 'toggleSubtask')->name('todo.subtask.toggle');
        });

        Route::controller(LoanController::class)->group(function () {
            Route::get('/loan', 'index')->name('loan.index');
            Route::post('/loan', 'store')->name('loan.store');
            Route::put('/loan/{loan}', 'update')->name('loan.update');
            Route::delete('/loan/{loan}', 'destroy')->name('loan.destroy');
        });

        Route::controller(LaporanController::class)->group(function () {
            Route::get('/laporan', 'index')->name('laporan.index');
        });

        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

        Route::controller(ProfileController::class)->group(function () {
            Route::get('/profile', 'index')->name('profile.index');
            Route::put('/profile/update', 'update')->name('profile.update');
            Route::put('/profile/change-password', 'changePassword')->name('profile.change-password');
            Route::put('/profile/avatar', 'updateAvatar')->name('profile.avatar');
        });

        Route::middleware('role:employer')->group(function () {
            Route::patch('/izin/{absent}/approve', [IzinController::class, 'approve'])->name('izin.approve');
            Route::patch('/izin/{absent}/reject', [IzinController::class, 'reject'])->name('izin.reject');

            Route::controller(EmployeeManagementController::class)->group(function () {
                Route::get('/karyawan', 'index')->name('karyawan.index');
                Route::post('/karyawan', 'store')->name('karyawan.store');

                Route::put('/karyawan/{id}', 'update')->name('karyawan.update');
                Route::delete('/karyawan/{id}', 'destroy')->name('karyawan.destroy');
            });

            Route::controller(DivisionController::class)->group(function () {
                Route::get('/divisi', 'index')->name('divisi.index');
                Route::post('/divisi', 'store')->name('divisi.store');
                Route::put('/divisi/{division}', 'update')->name('divisi.update');
                Route::delete('/divisi/{division}', 'destroy')->name('divisi.destroy');
            });

            Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
        });
    });
});
