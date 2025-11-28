<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\KategoriNamaTabunganController;
use App\Http\Controllers\KategoriJenisTabunganController;
use App\Http\Controllers\PlannedTransactionController;
use App\Http\Controllers\QuickCaptureController;
use App\Http\Controllers\ViewerController;
use Illuminate\Support\Facades\Http;

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
// Universal Tabungan Routes (Untuk semua role yang login)
// =======================
Route::middleware(['auth'])->group(function () {
    // Route tabungan index untuk semua role
    Route::get('/tabungan', [TabunganController::class, 'index'])->name('tabungan.index');

    Route::post('/quick-capture', [QuickCaptureController::class, 'store'])->name('quick-capture.store');
    
    // Export routes
    Route::get('/tabungan/export/excel', [TabunganController::class, 'exportExcel'])->name('tabungan.export.excel');
    Route::get('/tabungan/export/pdf', [TabunganController::class, 'exportPdf'])->name('tabungan.export.pdf');
    
    // Route khusus harus ditempatkan SEBELUM resource route
    // Route untuk fitur sampah (hanya untuk dins, tapi ditempatkan di sini untuk urutan)
    Route::middleware('role:dins')->group(function () {
        Route::get('/tabungan/trash', [TabunganController::class, 'trash'])->name('tabungan.trash');
        Route::patch('/tabungan/restore/{id}', [TabunganController::class, 'restore'])->name('tabungan.restore');
        Route::delete('/tabungan/force-delete/{id}', [TabunganController::class, 'forceDelete'])->name('tabungan.force-delete');
        Route::patch('/tabungan/restore-all', [TabunganController::class, 'restoreAll'])->name('tabungan.restore-all');
        Route::delete('/tabungan/empty-trash', [TabunganController::class, 'emptyTrash'])->name('tabungan.empty-trash');
    });
    
    // Resource route untuk tabungan (ditempatkan setelah route khusus)
    Route::resource('tabungan', TabunganController::class)->except(['index'])->names('tabungan');
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
// Auth Routes
// =======================
require __DIR__ . '/auth.php';