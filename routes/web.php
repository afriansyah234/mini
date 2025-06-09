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
    Route::resource('tugas', TugasController::class)->parameters([
        'tugas' => 'tugas'
    ]);
    Route::resource('project', ProjectController::class);
    Route::resource('laporan', LaporanController::class);
    Route::get('/kanban', [ProjectController::class, 'kanban'])->name('project.kanban');
    Route::post('/projects/{project}/status', [ProjectController::class, 'updateStatus'])->name('project.update-status');
});

Auth::routes();

Route::get('/karyawan', [App\Http\Controllers\KaryawanController::class, 'index'])->name('karyawan.index');

