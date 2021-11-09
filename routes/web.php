<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AutoCompleteController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriBukuController;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth
Route::get('/', [AuthController::class, 'formlogin'])->name('auth.index');
Route::get('auth/login', [AuthController::class, 'formlogin'])->name('auth.login');
Route::post('auth/login', [AuthController::class, 'login'])->name('auth.post.login');

// Autocomplete Buku
Route::get('/auto-buku', [AutoCompleteController::class, 'buku'])->name('auto.buku');

// Autocomplete ISBN
Route::get('/auto-isbn', [AutoCompleteController::class, 'isbn'])->name('auto.isbn');

// Daftar Anggota
Route::get('daftar', [AuthController::class, 'daftar_index'])->name('auth.daftar.index');
Route::post('daftar/post', [AuthController::class, 'daftar'])->name('auth.daftar.post');

// Route Akses
Route::group(['middleware' => 'auth'], function () {
    // Home
    Route::get('admin/home', [HomeController::class, 'index'])->name('admin.home');
    // Kelola User
    Route::group(['middleware' => ['can:kelola user']], function () {
        // Kelola Admin
        Route::get('admin/kelola/users/admin', [AdminController::class, 'index'])->name('index.user.admin');
        Route::get('admin/kelola/users/admin/tambah', [AdminController::class, 'tambah_index'])->name('tambah.index.user.admin');
        Route::post('admin/kelola/users/admin/tambah/post', [AdminController::class, 'tambah'])->name('tambah.post.user.admin');
        Route::get('admin/kelola/users/admin/edit/{id}', [AdminController::class, 'edit_index'])->name('edit.index.user.admin');
        Route::post('admin/kelola/users/admin/edit/{id}/post', [AdminController::class, 'edit'])->name('edit.post.user.admin');
        Route::get('admin/kelola/users/admin/hapus/{id}', [AdminController::class, 'hapus'])->name('hapus.user.admin');
        // Kelola Anggota
        Route::get('admin/kelola/users/anggota', [AnggotaController::class, 'index'])->name('index.user.anggota');
        Route::get('admin/kelola/users/anggota/tambah', [AnggotaController::class, 'tambah_index'])->name('tambah.index.user.anggota');
        Route::post('admin/kelola/users/anggota/tambah/post', [AnggotaController::class, 'tambah'])->name('tambah.post.user.anggota');
        Route::get('admin/kelola/users/anggota/edit/{id}', [AnggotaController::class, 'edit_index'])->name('edit.index.user.anggota');
        Route::post('admin/kelola/users/anggota/edit/{id}/post', [AnggotaController::class, 'edit'])->name('edit.post.user.anggota');
        Route::get('admin/kelola/users/anggota/hapus/{id}', [AnggotaController::class, 'hapus'])->name('hapus.user.anggota');
    });
    // Kelola Kategori Buku
    Route::group(['middleware' => ['can:kelola kategori buku']], function () {
        Route::get('admin/kelola/kategori', [KategoriBukuController::class, 'index'])->name('index.kategori');
        Route::get('admin/kelola/kategori/tambah', [KategoriBukuController::class, 'tambah_index'])->name('tambah.index.kategori');
        Route::post('admin/kelola/kategori/tambah/post', [KategoriBukuController::class, 'tambah'])->name('tambah.post.kategori');
        Route::get('admin/kelola/kategori/edit/{id}', [KategoriBukuController::class, 'edit_index'])->name('edit.index.kategori');
        Route::post('admin/kelola/kategori/edit/{id}/post', [KategoriBukuController::class, 'edit'])->name('edit.post.kategori');
        Route::get('admin/kelola/kategori/hapus/{id}', [KategoriBukuController::class, 'hapus'])->name('hapus.kategori');
    });
    // Kelola Buku
    Route::group(['middleware' => ['can:kelola buku']], function () {
        Route::get('admin/kelola/buku', [BukuController::class, 'index'])->name('index.buku');
        Route::get('admin/kelola/buku/tambah', [BukuController::class, 'tambah_index'])->name('tambah.index.buku');
        Route::post('admin/kelola/buku/tambah/post', [BukuController::class, 'tambah'])->name('tambah.post.buku');
        Route::get('admin/kelola/buku/edit/{id}', [BukuController::class, 'edit_index'])->name('edit.index.buku');
        Route::post('admin/kelola/buku/edit/{id}/post', [BukuController::class, 'edit'])->name('edit.post.buku');
        Route::get('admin/kelola/buku/hapus/{id}', [BukuController::class, 'hapus'])->name('hapus.buku');
    });
    // Kelola Transaksi
    Route::group(['middleware' => ['can:kelola transaksi']], function () {
        Route::get('admin/kelola/transaksi', [TransaksiController::class, 'index'])->name('index.transaksi');
        Route::get('admin/kelola/transaksi/tambah', [TransaksiController::class, 'tambah_index'])->name('tambah.index.transaksi');
        Route::post('admin/kelola/transaksi/tambah/post', [TransaksiController::class, 'tambah'])->name('tambah.post.transaksi');
        Route::get('admin/kelola/transaksi/edit/{id}', [TransaksiController::class, 'edit_index'])->name('edit.index.transaksi');
        Route::post('admin/kelola/transaksi/edit/{id}/post', [TransaksiController::class, 'edit'])->name('edit.post.transaksi');
        Route::get('admin/kelola/transaksi/hapus/{id}', [TransaksiController::class, 'hapus'])->name('hapus.transaksi');
        Route::get('admin/kelola/transaksi/kembali/{id}', [TransaksiController::class, 'kembali'])->name('kembali.transaksi');
    });

    Route::group(['middleware' => ['can:melakukan peminjaman']], function () {
        Route::get('pinjam/', [PinjamController::class, 'index'])->name('index.pinjam');
        Route::post('pinjam/post', [PinjamController::class, 'pinjam'])->name('post.pinjam');
        Route::get('pinjam/list', [PinjamController::class, 'list'])->name('list.pinjam');
        Route::get('pinjam/list/kembali/{id}', [PinjamController::class, 'kembali'])->name('kembali.pinjam');
    });
});
// Logout
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('get-logout', [AuthController::class, 'logout'])->name('get.logout');
