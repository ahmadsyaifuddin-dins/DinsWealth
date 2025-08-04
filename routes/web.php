<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\KategoriNamaTabunganController;
use App\Http\Controllers\KategoriJenisTabunganController;
use App\Http\Controllers\PlannedTransactionController;
use App\Http\Controllers\ViewerController;

// =======================
// Public Route
// =======================
Route::get('/', function () {
    return view('welcome');
});

// =======================
// Dashboard Redirect (Universal setelah login)
// =======================
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    $role = auth()->user()->role;

    return match ($role) {
        'dins' => redirect()->route('admin.dashboard'),
        'viewer' => redirect()->route('viewer.dashboard'),
        default => abort(403),
    };
})->name('dashboard');

// =======================
// Profile (Semua User)
// =======================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =======================
// Viewer Routes
// =======================
Route::middleware(['auth', 'role:viewer'])->group(function () {
    Route::get('/viewer/dashboard', [ViewerController::class, 'index'])->name('viewer.dashboard');
});

// =======================
// Dins (Admin) Routes
// =======================
Route::middleware(['auth', 'role:dins'])->group(function () {
    // Dashboard Admin
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Tabungan (CRUD)
    Route::resource('tabungan', TabunganController::class)->names('tabungan');

    // Backup
    Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
    Route::post('/backup/download', [BackupController::class, 'download'])->name('backup.download');

    // Planned Transaction (CRUD)
    Route::resource('planned-transactions', PlannedTransactionController::class);
    Route::post('/planned-transactions/{plannedTransaction}/complete', [PlannedTransactionController::class, 'complete'])->name('planned-transactions.complete');

    // Master Kategori
    Route::resource('kategori-nama-tabungan', KategoriNamaTabunganController::class)->names('kategori.nama');
    Route::resource('kategori-jenis-tabungan', KategoriJenisTabunganController::class)->names('kategori.jenis');
});

// =======================
// Universal Tabungan Index (Untuk semua role)
// =======================
Route::middleware(['auth'])->get('/tabungan', [TabunganController::class, 'index'])->name('tabungan.index');
Route::get('/tabungan/export/excel', [TabunganController::class, 'exportExcel'])->name('tabungan.export.excel');
Route::get('/tabungan/export/pdf', [TabunganController::class, 'exportPdf'])->name('tabungan.export.pdf');
// =======================
// Auth Routes
// =======================
require __DIR__ . '/auth.php';
