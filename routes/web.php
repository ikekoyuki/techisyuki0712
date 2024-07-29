<?php

use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('items')->group(function () {
    Route::get('/', [App\Http\Controllers\ItemController::class, 'index'])->name('index');
    Route::get('/add', [App\Http\Controllers\ItemController::class, 'add']);
    Route::post('/add', [App\Http\Controllers\ItemController::class, 'add']);

    Route::get('/edit/{id}', [App\Http\Controllers\ItemController::class, 'edit']);
    Route::post('/edit/{id}',[ItemController::class, 'edit']);

    Route::get('/dump/{id}',[ItemController::class, 'dump'])->name('dump');
    Route::get('/delete/{id}',[ItemController::class, 'delete'])->name('delete');

    Route::get('/lookback', [App\Http\Controllers\ItemController::class, 'lookback'])->name('lookback');

    Route::get('/undo/{id}', [App\Http\Controllers\ItemController::class, 'undo'])->name('undo');
});
