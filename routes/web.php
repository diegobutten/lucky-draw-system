<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DrawController;

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

Route::get('/', [DrawController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::post('/onLoad', [DrawController::class, 'onLoad']);
Route::post('/draw', [DrawController::class, 'draw']);
Route::post('/loadData/{data}', [DrawController::class, 'loadData']);
Route::post('/loadDataAdd/{data}', [DrawController::class, 'loadDataAdd']);
Route::post('/addLuckyNumber', [DrawController::class, 'addLuckyNumber']);
Route::post('/addNewUser', [DrawController::class, 'addNewUser']);
Route::post('/resetAllWinners', [DrawController::class, 'resetAllWinners']);

require __DIR__.'/auth.php';
