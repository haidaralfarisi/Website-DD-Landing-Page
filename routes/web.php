<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ADMIN\BerandaAdminController;
use App\Http\Controllers\ADMIN\PostController as ADMINPOST;
use App\Http\Controllers\SUPERADMIN\AchievementController;
use App\Http\Controllers\SUPERADMIN\BerandaSuperAdminController;
use App\Http\Controllers\SUPERADMIN\UserController;
use App\Http\Controllers\SUPERADMIN\CategoryController;
use App\Http\Controllers\SUPERADMIN\FacilityController;
use App\Http\Controllers\SUPERADMIN\PostCategoryController;
use App\Http\Controllers\SUPERADMIN\SliderController;
use App\Http\Controllers\SUPERADMIN\UnitController;
use App\Http\Controllers\SUPERADMIN\VideoController;
use App\Http\Controllers\SUPERADMIN\PostController as SUPERADMINPOST;
use App\Models\Achievement;

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
    Route::get('/postcategories', [PostCategoryController::class, 'index'])->name('postcategories.index');
    Route::post('/postcategories', [PostCategoryController::class, 'store'])->name('postcategories.store');
    Route::delete('/postcategories/{id}', [PostCategoryController::class, 'destroy'])->name('postcategories.destroy');
    Route::put('/postcategories/{id}', [PostCategoryController::class, 'update'])->name('postcategories.update');

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
    Route::get('/post', [SUPERADMINPOST::class, 'index'])->name('superadmin.posts.index');
    Route::get('/posts/create', [SUPERADMINPOST::class, 'create'])->name('superadmin.posts.create');
    Route::get('/posts/{post}/edit', [SUPERADMINPOST::class, 'edit'])->name('superadmin.posts.edit');
    Route::post('/post', [SUPERADMINPOST::class, 'store'])->name('superadmin.posts.store');
    Route::delete('/post/{id}', [SUPERADMINPOST::class, 'destroy'])->name('superadmin.posts.destroy');
    Route::put('/post/{id}', [SUPERADMINPOST::class, 'update'])->name('superadmin.posts.update');
    Route::post('/upload-image', [SUPERADMINPOST::class, 'uploadImage'])->name('superadmin.posts.uploadImage');


    # Untuk Aksi Data Slider
    Route::get('/slider', [SliderController::class, 'index'])->name('slider.index');
    Route::post('/slider', [SliderController::class, 'store'])->name('slider.store');
    Route::delete('/slider/{id}', [SliderController::class, 'destroy'])->name('slider.destroy');
    Route::put('/slider/{id}', [SliderController::class, 'update'])->name('slider.update');

    # Untuk Aksi Data Achievement
    Route::get('/achievement', [AchievementController::class, 'index'])->name('achievement.index');
    Route::post('/achievement', [AchievementController::class, 'store'])->name('achievement.store');
    Route::delete('/achievement/{id}', [AchievementController::class, 'destroy'])->name('achievement.destroy');
    Route::put('/achievement/{id}', [AchievementController::class, 'update'])->name('achievement.update');

    # Untuk Aksi Data Fasilitas
    Route::get('/facility', [FacilityController::class, 'index'])->name('facility.index');
    Route::post('/facility', [FacilityController::class, 'store'])->name('facility.store');
    Route::delete('/facility/{id}', [FacilityController::class, 'destroy'])->name('facility.destroy');
    Route::put('/facility/{id}', [FacilityController::class, 'update'])->name('facility.update');
});

# Admin
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    // Route::get('beranda', [BerandaAdminController::class, 'index'])->name('beranda');

    # Untuk Aksi Data Post
    Route::get('/post', [ADMINPOST::class, 'index'])->name('admin.posts.index');
    Route::post('/post', [ADMINPOST::class, 'store'])->name('admin.posts.store');
    Route::get('/posts/{post}/edit', [ADMINPOST::class, 'edit'])->name('admin.posts.edit');
    Route::get('/posts/create', [ADMINPOST::class, 'create'])->name('admin.posts.create');
    Route::delete('/post/{id}', [ADMINPOST::class, 'destroy'])->name('admin.posts.destroy');
    Route::put('/post/{id}', [ADMINPOST::class, 'update'])->name('admin.posts.update');
    Route::post('/upload-image', [ADMINPOST::class, 'uploadImage'])->name('admin.posts.uploadImage');

});
