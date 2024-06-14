<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstrukturController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SummernoteController;
use App\Http\Controllers\UjianInstrukturController;
use App\Http\Controllers\UjianPesertaController;
use App\Http\Controllers\UjianSiswaController;
use App\Models\Peserta;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route Auth
// ==>View
Route::get('/', [AuthController::class, 'index']);
// Route::get('/login_blk', [AuthController::class, 'index_blk']);
Route::get('/install', [AuthController::class, 'install']);
Route::get('/recovery', [AuthController::class, 'recovery']);
Route::get('/change_password/{token:token}', [AuthController::class, 'change_password']);
Route::get('/logout', [AuthController::class, 'logout']);
// ==>Function
Route::post('/login', [AuthController::class, 'login']);
// Route::post('/login_blk', [AuthController::class, 'login_blk']);
Route::post('/install', [AuthController::class, 'install_']);
Route::post('/recovery', [AuthController::class, 'recovery_']);
Route::get('/aktivasi/{token:token}', [AuthController::class, 'aktivasi']);
Route::post('/change_password/{token:token}', [AuthController::class, 'change_password_']);


// START::ROUTE ADMIN
Route::get('/admin', [AdminController::class, 'index'])->middleware('is_admin');
Route::get('/admin/profile', [AdminController::class, 'profile'])->middleware('is_admin');
Route::post('/admin/edit_profile/{admin:id}', [AdminController::class, 'edit_profile'])->middleware('is_admin');
Route::post('/admin/edit_password/{admin:id}', [AdminController::class, 'edit_password'])->middleware('is_admin');
Route::post('/admin/smtp_email/{id}', [AdminController::class, 'smtp_email'])->middleware('is_admin');

// ============INSTRUKTUR
// ==>View
Route::get('/admin/instruktur', [AdminController::class, 'instruktur'])->middleware('is_admin');
Route::get('/admin/edit_instruktur', [AdminController::class, 'edit_instruktur'])->name('ajaxinstruktur')->middleware('is_admin');
Route::get('/admin/impor_instruktur', [AdminController::class, 'impor_instruktur'])->middleware('is_admin');
Route::get('/admin/ekspor_insturktur', [AdminController::class, 'ekspor_instruktur'])->middleware('is_admin');

// ==>Function
Route::post('/admin/tambah_instruktur', [AdminController::class, 'tambah_instruktur'])->middleware('is_admin');
Route::post('/admin/edit_instruktur', [AdminController::class, 'edit_instruktur_'])->middleware('is_admin');
Route::post('/admin/impor_instruktur', [AdminController::class, 'impor_instruktur_'])->middleware('is_admin');
Route::get('/admin/hapus_instruktur/{instruktur:id}', [AdminController::class, 'hapus_instruktur'])->middleware('is_admin');

// =============Peserta
// ==>View
Route::get('/admin/peserta', [AdminController::class, 'peserta'])->middleware('is_admin');
Route::post('/admin/peserta', [AdminController::class, 'filter_peserta'])->middleware('is_admin');

// ============Pelatihan
// ==>View
Route::get('/admin/pelatihan', [AdminController::class, 'pelatihan'])->middleware('is_admin');

// ===========Gelombang
// ==>View
Route::get('/admin/gelombang', [AdminController::class, 'gelombang'])->middleware('is_admin');
Route::post('/admin/gelombang', [AdminController::class, 'filter_list_gelombang'])->middleware('is_admin');

// ============RELASI
// ==>View
Route::get('/admin/relasi', [AdminController::class, 'relasi'])->middleware('is_admin');
Route::get('/admin/relasi_instruktur/{instruktur:id}', [AdminController::class, 'relasi_instruktur'])->middleware('is_admin');
// ==>Function
Route::get('/admin/instruktur_pelatihan', [AdminController::class, 'instruktur_pelatihan'])->name('instruktur_pelatihan')->middleware('is_admin');
// END::ROUTE ADMIN

// SUMMERNOTE
Route::post('/summernote/upload', [SummernoteController::class, 'upload'])->name('summernote_upload');
Route::post('/summernote/delete', [SummernoteController::class, 'delete'])->name('summernote_delete');
Route::get('/summernote/unduh/{file}', [SummernoteController::class, 'unduh']);
Route::post('/summernote/delete_file', [SummernoteController::class, 'delete_file']);

// START::ROUTE INSTRUKTUR
Route::get('/instruktur', [InstrukturController::class, 'index'])->middleware('is_instruktur');
Route::get('/instruktur/profile', [InstrukturController::class, 'profile'])->middleware('is_instruktur');
Route::post('/instruktur/edit_profile/{instruktur:id}', [InstrukturController::class, 'edit_profile'])->middleware('is_instruktur');
Route::post('/instruktur/edit_password/{instruktur:id}', [InstrukturController::class, 'edit_password'])->middleware('is_instruktur');
Route::post('/instruktur/edit_ujian/{id}', [InstrukturController::class, 'edit_ujian'])->middleware('is_instruktur');

// ==>Ujian
Route::resource('/instruktur/ujian', UjianInstrukturController::class)->middleware('is_instruktur');
Route::post('/instruktur/pg_excel', [UjianInstrukturController::class, 'pg_excel'])->middleware('is_instruktur');
Route::get('/instruktur/ujian/{kode}/{siswa_id}', [UjianInstrukturController::class, 'pg_instruktur'])->middleware('is_instruktur');
Route::get('/instruktur/ujian_cetak/{kode}', [UjianInstrukturController::class, 'ujian_cetak'])->middleware('is_instruktur');
Route::get('/instruktur/ujian_ekspor/{kode}', [UjianInstrukturController::class, 'ujian_ekspor'])->middleware('is_instruktur');

// ===>Ujian
Route::resource('/instruktur/ujian', UjianInstrukturController::class)->middleware('is_instruktur');
// END ROUTE Instruktur

// START::ROUTE Peserta
Route::get('/peserta', [PesertaController::class, 'index'])->middleware('is_peserta');

// Ujian Peserta
Route::resource('/peserta/ujian', UjianPesertaController::class)->middleware('is_peserta');
Route::post('/peserta/simpan_pg', [UjianPesertaController::class, 'simpan_pg'])->middleware('is_peserta');
Route::post('/peserta/ragu_pg', [UjianPesertaController::class, 'ragu_pg'])->middleware('is_peserta');

Route::get('/filter/gelombang/{id}', [AdminController::class, 'filter_gelombang'])->middleware('is_admin');

Route::get('/admin/show_gelombang', [AdminController::class, 'show_gelombang'])->name('ajaxshowgelombang')->middleware('is_admin');
Route::post('/admin/edit_gelombang', [AdminController::class, 'edit_gelombang'])->middleware('is_admin');

