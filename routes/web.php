<?php

use Illuminate\Support\Facades\Route;

// AUTH
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// ADMIN area
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogTagController;
use App\Http\Controllers\Admin\BlogPostController;

// PETUGAS
use App\Http\Controllers\PetugasDashboardController;

// notifikasi email
use Illuminate\Support\Facades\Mail;

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
// Halaman Utama (pilih salah satu opsi)
// --------------------------------------------------

// Opsi A: tetap tampilkan welcome:
Route::get('/', function () {
    return view('welcome');
});

// Opsi B: kalau mau langsung redirect ke halaman login:
// Route::get('/', fn() => redirect('/login'));


// -----------------------------
// AUTHENTICATION
// -----------------------------

// REGISTER
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

// LOGIN & LOGOUT
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// -----------------------------
// PASSWORD RESET FLOW (diambil dari kode lama)
// -----------------------------

// Forgot password (form + kirim link reset)
Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])
    ->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])
    ->name('password.email');

// Reset password (form + submit password baru)
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'index'])
    ->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
    ->name('password.update');


// -----------------------------
// DASHBOARD & FITUR BERDASARKAN ROLE
// -----------------------------

// ADMIN
Route::middleware(['auth', 'role:Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Kategori Produk
        Route::resource('categories', ProductCategoryController::class);

        // Produk
        Route::resource('products', ProductController::class);

        // BLOG
        Route::resource('blog/categories', BlogCategoryController::class)
            ->names('blog.categories'); // admin.blog.categories.*
        Route::resource('blog/tags', BlogTagController::class)
            ->names('blog.tags');       // admin.blog.tags.*
        Route::resource('blog/posts', BlogPostController::class)
            ->names('blog.posts');      // admin.blog.posts.*
    });

// PETUGAS
Route::middleware(['auth', 'role:Petugas'])
    ->get('/petugas', [PetugasDashboardController::class, 'index'])
    ->name('petugas.dashboard');
