<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OtbPersiteNToNController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return redirect('/login');
});


Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
Route::get('/maps', [App\Http\Controllers\HomeController::class, 'show'])->name('maps');
Route::resource('customer', CustomerController::class);
Route::post('/customer/status/{id}', [CustomerController::class, 'changeStatus'])->name('customer.changeStatus');
Route::resource('otb_persite_n_t_on', OtbPersiteNToNController::class);
