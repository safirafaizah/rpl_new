<?php

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

Route::get('/', function () {
    return view('welcome');
})->name('index');

Auth::routes([
    'register' => false, // Registration Routes...
  ]);

Route::get('/login/sso_klas2/', [App\Http\Controllers\HomeController::class, 'sso_klas2'])->name('sso_klas2');
Route::get('/login/google', [App\Http\Controllers\GoogleController::class, 'redirectToGoogle']);
Route::get('/login/google/callback', [App\Http\Controllers\GoogleController::class, 'handleCallback']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['auth']);

//MAIN
Route::group(['prefix' => 'rekognisi','middleware' => ['auth','role:4']], function () {
  Route::any('/', [App\Http\Controllers\RekognisiController::class, 'index'])->name('rekognisi.index');
  Route::get('/data', [App\Http\Controllers\RekognisiController::class, 'data'])->name('rekognisi.data');
  Route::any('/ubah/{id}', [App\Http\Controllers\RekognisiController::class, 'ubah'])->name('rekognisi.ubah');
  Route::delete('/hapus', [App\Http\Controllers\RekognisiController::class, 'hapus'])->name('rekognisi.hapus');
});

Route::group(['prefix' => 'verifikasi','middleware' => ['auth','role:3,4']], function () {
  Route::any('/', [App\Http\Controllers\VerifikasiController::class, 'index'])->name('verifikasi.index');
  Route::get('/data', [App\Http\Controllers\VerifikasiController::class, 'data'])->name('verifikasi.data');
  Route::any('/{id}', [App\Http\Controllers\VerifikasiController::class, 'lihat'])->name('verifikasi.lihat');
});


Route::group(['prefix' => 'jadwal','middleware' => ['auth']], function () {
  Route::any('/', [App\Http\Controllers\JadwalController::class, 'index'])->name('jadwal.index');
  Route::get('/data', [App\Http\Controllers\JadwalController::class, 'data'])->name('jadwal.data');
});

Route::group(['prefix' => 'pengaturan','middleware' => ['auth','role:1']], function () {
  Route::get('akun', [App\Http\Controllers\PengaturanController::class, 'akun'])->name('pengaturan.akun');
  Route::get('akun/data', [App\Http\Controllers\PengaturanController::class, 'akun_data'])->name('pengaturan_akun_data');
  Route::any('akun/ubah/{id}', [App\Http\Controllers\PengaturanController::class, 'akun_ubah'])->name('pengaturan_akun_ubah');

  Route::any('matakuliah', [App\Http\Controllers\PengaturanController::class, 'matakuliah'])->name('pengaturan.matakuliah');
  Route::get('matakuliah/data', [App\Http\Controllers\PengaturanController::class, 'matakuliah_data'])->name('pengaturan_matakuliah_data');
  Route::delete('matakuliah/hapus', [App\Http\Controllers\PengaturanController::class, 'matakuliah_hapus'])->name('pengaturan_matakuliah_hapus');
  Route::any('matakuliah/ubah/{id}', [App\Http\Controllers\PengaturanController::class, 'matakuliah_ubah'])->name('pengaturan_matakuliah_ubah');



});



Route::get('log-viewers', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->middleware(['auth', 'role:1']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
