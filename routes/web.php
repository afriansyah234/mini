<?php

use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\ProjectController;
use App\Models\Laporan;

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

Route::middleware(['auth'])->group(function () {
    Route::resource('karyawan', KaryawanController::class);
    Route::resource('tugas', TugasController::class);
    Route::resource('project', ProjectController::class);
    Route::resource('laporan',LaporanController::class);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

