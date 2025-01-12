<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ADMIN\BerandaAdminController;
use App\Http\Controllers\ADMIN\PostController;

use App\Http\Controllers\SUPERADMIN\BerandaSuperAdminController;
use App\Http\Controllers\SUPERADMIN\UserController;
use App\Http\Controllers\SUPERADMIN\CategoryController;
use App\Http\Controllers\SUPERADMIN\SliderController;
use App\Http\Controllers\SUPERADMIN\UnitController;
use App\Http\Controllers\SUPERADMIN\VideoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'register' => false, // Nonaktifkan rute registrasi
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

# SuperAdmin
Route::prefix('superadmin')->middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('beranda', [BerandaSuperAdminController::class, 'index'])->name('beranda');

    # Untuk Aksi Data User
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    // Route::get('/admin/user/{id}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

    # Untuk Aksi Data Category
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');

    # Untuk Aksi Data Unit
    Route::get('/unit', [UnitController::class, 'index'])->name('unit.index');
    Route::post('/unit', [UnitController::class, 'store'])->name('unit.store');
    Route::delete('/unit/{id}', [UnitController::class, 'destroy'])->name('unit.destroy');
    Route::put('/unit/{id}', [UnitController::class, 'update'])->name('unit.update');


    # Untuk Aksi Data Video
    Route::get('/video', [VideoController::class, 'index'])->name('video.index');
    Route::post('/video', [VideoController::class, 'store'])->name('video.store');
    Route::delete('/video/{id}', [VideoController::class, 'destroy'])->name('video.destroy');
    Route::put('/video/{id}', [VideoController::class, 'update'])->name('video.update');

    # Untuk Aksi Data Post
    Route::get('/post', [VideoController::class, 'index'])->name('post.index');
    Route::post('/post', [VideoController::class, 'store'])->name('post.store');
    Route::delete('/post/{id}', [VideoController::class, 'destroy'])->name('post.destroy');
    Route::put('/post/{id}', [VideoController::class, 'update'])->name('post.update');

    # Untuk Aksi Data Slider
    Route::get('/slider', [SliderController::class, 'index'])->name('slider.index');
    Route::post('/slider', [SliderController::class, 'store'])->name('slider.store');
    Route::delete('/slider/{id}', [SliderController::class, 'destroy'])->name('slider.destroy');
    Route::put('/slider/{id}', [SliderController::class, 'update'])->name('slider.update');

});

# Admin
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('beranda', [BerandaAdminController::class, 'index'])->name('admin.index');

    # Untuk Aksi Data Post
    Route::get('/post', [VideoController::class, 'index'])->name('posts.index');
    Route::post('/post', [VideoController::class, 'store'])->name('post.store');
    Route::delete('/post/{id}', [VideoController::class, 'destroy'])->name('post.destroy');
    Route::put('/post/{id}', [VideoController::class, 'update'])->name('post.update');
});
