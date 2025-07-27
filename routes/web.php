<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TabunganController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard (masuk dari redirect login)
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Halaman Profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rute Universal Tabungan (logic dibedakan di dalam controller)
Route::middleware(['auth'])->get('/tabungan', [TabunganController::class, 'index'])->name('tabungan.index');

// Dashboard Admin (opsional, bisa dijadikan /dashboard juga)
Route::middleware(['auth', 'role:dins'])->get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::middleware(['auth', 'role:dins'])->post('/admin/tabungan', [TabunganController::class, 'store'])->name('admin.tabungan.store');
// Route::middleware(['auth', 'role:dins'])->get('/admin/tabungan', [TabunganController::class, 'create'])->name('admin.tabungan.create');


Route::middleware(['auth', 'role:viewer'])->group(function () {
    Route::get('/viewer/dashboard', function () {
        return view('viewer.dashboard');
    })->name('viewer.dashboard');
});

require __DIR__.'/auth.php';
