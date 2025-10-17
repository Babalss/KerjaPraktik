<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PetugasDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sinilah kamu dapat mendaftarkan route web untuk aplikasi.
| Route ini dimuat oleh RouteServiceProvider dan semuanya akan
| dimasukkan dalam group "web" middleware.
|
*/

// --------------------------------------------------
// Halaman Utama
// --------------------------------------------------
Route::get('/', function () {
    return view('welcome');
});




Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);


Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);


Route::middleware(['auth', 'role:Admin'])
    ->get('/admin', [AdminDashboardController::class, 'index'])
    ->name('admin.dashboard');


Route::middleware(['auth', 'role:Petugas'])
    ->get('/petugas', [PetugasDashboardController::class, 'index'])
    ->name('petugas.dashboard');
