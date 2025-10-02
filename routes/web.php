<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // Impor controller Auth
use App\Http\Controllers\Auth\SocialiteController; // Impor controller Socialite
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManageDataController; // Impor controller ManageData
use App\Http\Controllers\KaprodiController;
use App\Http\Controllers\AngkatanController;

use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanAngkatanController;

use App\Http\Controllers\ProdiController;



use App\Http\Controllers\DosenController;

// Impor controller lainnya sesuai kebutuhan (Dosen, Akademik, Kaprodi, Wadir)

// Route untuk halaman utama (bisa diarahkan ke login)
Route::get('/', function () {
    return redirect('/login');
});

// Route untuk login manual
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Route untuk logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route untuk Google SSO
Route::get('/auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Route untuk dashboard (setelah login)
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard'); // Middleware 'auth' untuk proteksi

// Kelola Akun Pengguna (Admin)
Route::get('/admin/manage/users', [AdminController::class, 'manageUsers'])->name('admin.manage.users');
Route::get('/admin/manage/users/create', [AdminController::class, 'showCreateUserForm'])->name('admin.create.user.form');
Route::post('/admin/manage/users', [AdminController::class, 'storeUser'])->name('admin.create.user');

    // Tambahkan route untuk edit dan delete
    Route::get('/admin/manage/users/{id}/edit', [AdminController::class, 'showEditUserForm'])->name('admin.edit.user.form'); // Menampilkan form edit
    Route::put('/admin/manage/users/{id}', [AdminController::class, 'updateUser'])->name('admin.update.user'); // Proses update
    Route::delete('/admin/manage/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.delete.user'); // Proses delete

// Kelola Data Master (Admin) - Gunakan ManageDataController
Route::get('/admin/manage/prodi', [ManageDataController::class, 'indexProdi'])->name('admin.manage.prodi');
Route::get('/admin/manage/prodi/create', [ManageDataController::class, 'showCreateProdiForm'])->name('admin.create.prodi.form');
Route::post('/admin/manage/prodi', [ManageDataController::class, 'storeProdi'])->name('admin.create.prodi');
// Tambahkan route untuk edit/update/hapus jika diperlukan nanti


// Tambahkan route untuk edit/update/hapus jika diperlukan nanti

Route::get('/admin/manage/matkul', [ManageDataController::class, 'indexMatkul'])->name('admin.manage.matkul');
Route::get('/admin/manage/matkul/create', [ManageDataController::class, 'showCreateMatkulForm'])->name('admin.create.matkul.form');
Route::post('/admin/manage/matkul', [ManageDataController::class, 'storeMatkul'])->name('admin.create.matkul');
// Tambahkan route untuk edit/update/hapus jika diperlukan nanti
// Kelola CPL, CPMK, Mapping (Akademik Prodi) - Buat controller baru nanti, misalnya AkademikController
// Route::get('/akademik/cpl', [AkademikController::class, 'indexCpl'])->name('akademik.cpl');
// Route::get('/akademik/cpmk', [AkademikController::class, 'indexCpmk'])->name('akademik.cpmk');
// Route::get('/akademik/mapping', [AkademikController::class, 'indexMapping'])->name('akademik.mapping');
// ... tambahkan route lainnya sesuai kebutuhan

// Input Nilai, Kelola CPMK (Dosen) - Buat controller baru nanti, misalnya DosenController
// Route::get('/dosen/cpmk', [DosenController::class, 'indexCpmk'])->name('dosen.cpmk');
// Route::get('/dosen/input/nilai', [DosenController::class, 'inputNilai'])->name('dosen.input.nilai');
// ... tambahkan route lainnya sesuai kebutuhan

// Laporan CPL (Kaprodi) - Buat controller baru nanti, misalnya KaprodiController
// Route::get('/kaprodi/laporan/cpl/matakuliah', [KaprodiController::class, 'laporanCplPerMk'])->name('kaprodi.laporan.cpl.matakuliah');
// Route::get('/kaprodi/laporan/cpl/angkatan', [KaprodiController::class, 'laporanCplPerAngkatan'])->name('kaprodi.laporan.cpl.angkatan');
// Route::get('/kaprodi/generate/rumusan', [KaprodiController::class, 'generateRumusan'])->name('kaprodi.generate.rumusan');
// ... tambahkan route lainnya sesuai kebutuhan

// Laporan Agregat (Wadir I) - Buat controller baru nanti, misalnya WadirController
// Route::get('/wadir/laporan/cpl/lintasprodi', [WadirController::class, 'laporanCplLintasProdi'])->name('wadir.laporan.cpl.lintasprodi');
// Route::get('/wadir/generate/laporan', [WadirController::class, 'generateLaporanAkademik'])->name('wadir.generate.laporan');
// ... tambahkan route lainnya sesuai kebutuhan
// routes/web.php (lanjutan dari sebelumnya)

// Kelola Data Master (Admin) - Gunakan ManageDataController
Route::get('/admin/manage/prodi', [ManageDataController::class, 'indexProdi'])->name('admin.manage.prodi');
Route::get('/admin/manage/prodi/create', [ManageDataController::class, 'showCreateProdiForm'])->name('admin.create.prodi.form');
Route::post('/admin/manage/prodi', [ManageDataController::class, 'storeProdi'])->name('admin.create.prodi');
// Tambahkan route untuk edit/update/hapus jika diperlukan nanti

// --- TAMBAHKAN BAGIAN INI ---
Route::get('/admin/manage/mahasiswa', [ManageDataController::class, 'indexMahasiswa'])->name('admin.manage.mahasiswa');
Route::get('/admin/manage/mahasiswa/create', [ManageDataController::class, 'showCreateMahasiswaForm'])->name('admin.create.mahasiswa.form');
Route::post('/admin/manage/mahasiswa', [ManageDataController::class, 'storeMahasiswa'])->name('admin.create.mahasiswa');
// Tambahkan route untuk edit/update/hapus jika diperlukan nanti
// route edit & update
Route::get('/admin/manage/mahasiswa/{id}/edit', [ManageDataController::class, 'editMahasiswa'])->name('admin.edit.mahasiswa');
Route::put('/admin/manage/mahasiswa/{id}', [ManageDataController::class, 'updateMahasiswa'])->name('admin.update.mahasiswa');

// route hapus
Route::delete('/admin/manage/mahasiswa/{id}', [ManageDataController::class, 'deleteMahasiswa'])->name('admin.delete.mahasiswa');
// --- /TAMBAHKAN BAGIAN INI ---

// Route::get('/admin/manage/angkatan', [ManageDataController::class, 'indexAngkatan'])->name('admin.manage.angkatan');
// Route::get('/admin/manage/matkul', [ManageDataController::class, 'indexMatkul'])->name('admin.manage.matkul');
// ... tambahkan route lainnya sesuai kebutuhan

// route Kaprodi
// route Kaprodi


// Tambahkan di bawah sini
Route::middleware(['auth'])->group(function () {
       
    // Route untuk MENAMPILKAN form tambah user baru
    Route::get('/admin/manage/users/create', [AdminController::class, 'showCreateUserForm'])->name('admin.create.user.form');
    
    // Route untuk MENYIMPAN data user baru yang dikirim dari form
    Route::post('/admin/manage/users', [AdminController::class, 'storeUser'])->name('admin.create.user');
    // Admin dashboard
    Route::get('/admin/dashboard', function () {
        return view('dashboard'); // resources/views/dashboard.blade.php
    })->name('admin.dashboard');
    // Route resource untuk Prodi - INI YANG PENTING
    Route::resource('prodi', \App\Http\Controllers\ProdiController::class);
    // Kaprodi dashboard
    Route::get('/kaprodi/dashboard', [KaprodiController::class, 'index'])
        ->name('kaprodi.dashboard');
        Route::get('/dosen/dashboard', [DosenController::class, 'index'])
        ->name('dosen.dashboard');
        Route::get('/dosen/dashboard', [DosenController::class, 'dashboard'])->name('dosen.dashboard');
});

Route::get('/kaprodi/laporan/mk', [LaporanController::class, 'laporanMK'])->name('kaprodi.laporan.mk');
Route::get('/kaprodi/laporan/mk/export/{format}', [LaporanController::class, 'exportMK'])->name('kaprodi.laporan.mk.export');

Route::prefix('kaprodi')->name('kaprodi.')->group(function () {
    Route::get('/laporan/angkatan', [LaporanAngkatanController::class, 'index'])->name('laporan.angkatan');
    Route::get('/laporan/angkatan/export/{format}', [LaporanAngkatanController::class, 'export'])->name('laporan.angkatan.export');
});

Route::post('/admin/mahasiswa/store', [ManageDataController::class, 'storeMahasiswa'])
    ->name('mahasiswa.store');

    // Kelola Angkatan (Admin) - Gunakan AngkatanController
Route::get('/admin/manage/angkatan', [AngkatanController::class, 'index'])->name('admin.manage.angkatan');
Route::get('/admin/manage/angkatan/create', [AngkatanController::class, 'create'])->name('angkatan.create');
Route::post('/admin/manage/angkatan/store', [AngkatanController::class, 'store'])->name('angkatan.store');
Route::get('/admin/angkatan/{id}/edit', [AngkatanController::class, 'edit'])->name('angkatan.edit');
Route::put('/admin/angkatan/{id}', [AngkatanController::class, 'update'])->name('angkatan.update');
Route::delete('/admin/angkatan/{id}', [AngkatanController::class, 'destroy'])->name('angkatan.delete');

