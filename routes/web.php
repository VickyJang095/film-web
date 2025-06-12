<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Models\Movie;

// Trang chủ
Route::get('/', function () {
    $featuredMovie = Movie::where('status', 'published')
        ->orderBy('rating', 'desc')
        ->first();
    $latestMovie = Movie::where('status', 'published')
        ->latest()
        ->first();
    $featuredMovies = Movie::where('status', 'published')
        ->orderBy('rating', 'desc')
        ->take(3)
        ->get();
    return view('welcome', compact('featuredMovie', 'latestMovie', 'featuredMovies'));
})->name('welcome');

// Routes công khai
Route::get('/search', [MovieController::class, 'search'])->name('search');
Route::get('/movies/latest', [MovieController::class, 'latest'])->name('movies.latest');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/country/{slug}', [CountryController::class, 'show'])->name('country.show');

// Routes cho người dùng đã đăng nhập (ngoại trừ dashboard)
Route::middleware(['auth', 'verified'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes cho phim
    Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
    Route::get('/movies/{movie:slug}', [MovieController::class, 'show'])->name('movies.show');
    Route::get('/movies/{movie:slug}/episodes/{episode}', [EpisodeController::class, 'show'])->name('episode.show');

    // Routes cho bình luận
    Route::post('/movies/{movie}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Routes cho Admin (bao gồm dashboard)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Quản lý phim (chỉ admin)
    Route::get('/movies/create', [MovieController::class, 'create'])->name('movies.create');
    Route::post('/movies', [MovieController::class, 'store'])->name('movies.store');
    Route::get('/movies/{movie}/edit', [MovieController::class, 'edit'])->name('movies.edit');
    Route::put('/movies/{movie}', [MovieController::class, 'update'])->name('movies.update');
    Route::delete('/movies/{movie}', [MovieController::class, 'destroy'])->name('movies.destroy');
});

// Nếu bạn muốn dashboard không ở trong prefix /admin, bạn có thể tạo route riêng như sau:
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
});

// Routes cho Admin và Editor (manage)
Route::middleware(['auth', 'role:admin,editor'])->prefix('manage')->group(function () {
    Route::get('/', [ManageController::class, 'index'])->name('manage.index');
});

require __DIR__.'/auth.php';
