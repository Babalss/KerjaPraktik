<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\BlogTagController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\PetugasDashboardController;
use App\Http\Controllers\Admin\BlogCategoryController;

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

Route::prefix('admin')->group(function () {});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);


Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);


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




Route::middleware(['auth', 'role:Petugas'])
    ->get('/petugas', [PetugasDashboardController::class, 'index'])
    ->name('petugas.dashboard');
