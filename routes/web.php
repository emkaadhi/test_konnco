<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/pesan/{id}', [App\Http\Controllers\PesanController::class, 'index']);
Route::post('/pesan/{id}', [App\Http\Controllers\PesanController::class, 'pesan']);
Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index']);
Route::delete('/checkout/{id}', [App\Http\Controllers\CheckoutController::class, 'delete']);
Route::get('/konfirmasi', [App\Http\Controllers\CheckoutController::class, 'konfirmasi']);
// Route::get('/checkout/payment', [App\Http\Controllers\CheckoutController::class, 'process']->name('test'));
Route::get('/checkout/payment/{transaction}', [CheckoutController::class, 'payment'])->name('payment');
Route::get('/checkout/payment/{transaction}', [CheckoutController::class, 'payment'])->name('payment');
Route::get('/transaction/{transaction}', [CheckoutController::class, 'success'])->name('success');