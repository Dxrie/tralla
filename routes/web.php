<?php

<<<<<<< HEAD
use App\Http\Controllers\TodoController;
=======
>>>>>>> origin/main
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', [DashboardController::class, 'about'])->name('about');

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
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile');
        Route::get('/profile/edit', 'edit')->name('edit');
        Route::put('/profile/update', 'update')->name('update');
    });

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::get('/todo', [TodoController::class, 'index']);
Route::post('/todos', [TodoController::class, 'store']);

Route::get('/todos', [TodoController::class, 'create']);
Route::get('/todos/{todo}/edit', [TodoController::class, 'edit']);
Route::put('/todos/{todo}', [TodoController::class, 'update']);
Route::delete('/todos/{todo}', [TodoController::class, 'destroy']);