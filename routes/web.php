<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\DataOtbController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OtbPersiteNToNController;

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
Route::get('/customers/map', [CustomerController::class, 'showMap'])->name('customers.map');
Route::resource('data_otb', DataOtbController::class);
Route::get('/data-otb/site', [DataOtbController::class, 'site'])->name('data_otb.site');
Route::get('/data-otb', [DataOtbController::class, 'index'])->name('data_otb.index');
Route::get('/data-otb/get-data', [DataOtbController::class, 'getData'])->name('data_otb.get_data');
Route::post('/data-otb/store', [DataOtbController::class, 'store'])->name('data_otb.store');
Route::get('/sata-otb/map', [DataOtbController::class, 'showMap'])->name('data_otb.map');
Route::get('/sata-otb/allsite', [DataOtbController::class, 'showAllMap'])->name('data_otb.allsite');
Route::get('asset/index', [AssetController::class, 'index'])->name('asset.index');
Route::post('asset/store', [AssetController::class, 'store'])->name('asset.store');
Route::get('/get-image-by-site', [AssetController::class, 'getImageBySite']);
