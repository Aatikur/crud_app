<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;
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
});
Route::get('/vendors',[VendorController::class,'vendorList']);
Route::get('/vendors/{vendorId}',[VendorController::class,'getVendor']);
Route::post('/vendors',[VendorController::class,'addVendor']);
Route::post('/locations',[VendorController::class,'addLocation']);