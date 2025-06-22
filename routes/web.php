<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controller untuk Masyarakat
use App\Http\Controllers\Masyarakat\DashboardController as MasyarakatDashboardController;
use App\Http\Controllers\Masyarakat\PengaduanController as MasyarakatPengaduanController;
use App\Http\Controllers\Masyarakat\NotifikasiController as MasyarakatNotifikasiController;
// use App\Http\Controllers\Masyarakat\PageController as MasyarakatPageController; // Tidak lagi diperlukan jika view statis

// Controller untuk Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PengaduanController as AdminPengaduanController;
use App\Http\Controllers\Admin\KategoriLaporanController as AdminKategoriLaporanController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

// Controller untuk Halaman Utama
use App\Http\Controllers\WelcomeController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda mendaftarkan semua rute untuk aplikasi Anda.
|
*/

// Halaman Utama (Welcome Page)
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');


// Rute untuk halaman Panduan Bantuan yang bisa diakses publik
Route::get('/panduan-bantuan', function () {
    return view('pages.panduan');
})->name('panduan.bantuan');

// Rute Autentikasi yang dibuat oleh Laravel Breeze
require __DIR__.'/auth.php';

// Grup Rute yang hanya bisa diakses oleh pengguna yang sudah login dan terverifikasi
Route::middleware(['auth', 'verified'])->group(function () {

    // Rute /dashboard utama yang akan mengarahkan berdasarkan role
    Route::get('/dashboard', function () {
        if (auth()->user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->role == 'masyarakat') {
            return app(MasyarakatDashboardController::class)->index();
        }

        Auth::logout();
        return redirect('/login')->with('error', 'Role pengguna tidak dikenali.');

    })->name('dashboard');

    // Rute untuk mengelola profil pengguna sendiri
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // -- Rute Khusus untuk Masyarakat --
    Route::prefix('masyarakat')->name('masyarakat.')->group(function () {
        // Rute untuk fitur pengaduan
        Route::prefix('pengaduan')->name('pengaduan.')->group(function () {
            Route::get('/', [MasyarakatPengaduanController::class, 'index'])->name('index');
            Route::get('/buat', [MasyarakatPengaduanController::class, 'create'])->name('create');
            Route::post('/', [MasyarakatPengaduanController::class, 'store'])->name('store');
            Route::get('/{pengaduan:slug}', [MasyarakatPengaduanController::class, 'show'])->name('show');
        });

        // Rute untuk notifikasi
        Route::prefix('notifikasi')->name('notifikasi.')->group(function () {
            Route::get('/', [MasyarakatNotifikasiController::class, 'index'])->name('index');
            Route::patch('/{notifikasi}/read', [MasyarakatNotifikasiController::class, 'markAsRead'])->name('mark_as_read');
            Route::patch('/mark-all-read', [MasyarakatNotifikasiController::class, 'markAllAsRead'])->name('mark_all_as_read');
            Route::get('/unread-count', [MasyarakatNotifikasiController::class, 'getUnreadCount'])->name('unread_count');
        });

        // Rute untuk halaman "Tentang Kami" yang langsung menampilkan view statis
        Route::get('/tentang-kami', function() {
            return view('masyarakat.about');
        })->name('about');
    });
});


// Grup Rute untuk Panel Admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Rute untuk mengelola semua pengaduan
    Route::prefix('pengaduan')->name('pengaduan.')->group(function () {
        Route::get('/', [AdminPengaduanController::class, 'index'])->name('index');
        Route::get('/{pengaduan:slug}', [AdminPengaduanController::class, 'show'])->name('show');
        Route::put('/{pengaduan:slug}/update-status', [AdminPengaduanController::class, 'updateStatus'])->name('update_status');
        Route::delete('/{pengaduan:slug}', [AdminPengaduanController::class, 'destroy'])->name('destroy');
    });

    // Rute untuk mengelola Kategori Laporan (CRUD)
    Route::resource('kategori', AdminKategoriLaporanController::class)->parameters(['kategori' => 'kategori']);

    // Rute untuk mengelola Pengguna (CRUD)
    Route::resource('users', AdminUserController::class)->parameters(['users' => 'user'])->except(['create', 'store']);
});
