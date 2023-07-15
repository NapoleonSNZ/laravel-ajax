<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;

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


Route::get('/', [EmpleadoController::class, 'index']);
Route::post('/store', [EmpleadoController::class, 'store'])->name('store');
Route::get('/fetch-all', [EmpleadoController::class, 'fetchAll'])->name('fetchAll');
Route::get('/edit', [EmpleadoController::class, 'edit'])->name('edit');
Route::post('/update', [EmpleadoController::class, 'update'])->name('update');
Route::delete('/delete', [EmpleadoController::class, 'delete'])->name('delete');
