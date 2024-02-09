<?php

use App\Http\Controllers\api\barangController;
use App\Http\Controllers\api\keranjangController;
use App\Http\Controllers\api\mejaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('v1/barang', [barangController::class, 'index']);
Route::post('v1/barang', [barangController::class, 'store']);
Route::delete('v1/barang/{id}', [barangController::class, 'destroy']);
Route::get('v1/barang/search', [barangController::class, 'find']);
Route::get('v1/barang/{id}', [barangController::class, 'show']);

Route::get('v1/meja', [mejaController::class, 'index']);
Route::post('v1/meja', [mejaController::class, 'store']);
Route::get('v1/meja/{id}', [mejaController::class, 'cari']);

Route::post('v1/keranjang', [keranjangController::class, 'store']);
Route::get('v1/keranjang', [keranjangController::class, 'index']);
Route::patch('v1/keranjang/{id}', [keranjangController::class, 'tambahQty']);
Route::delete('v1/keranjang/{id}', [keranjangController::class, 'destroy']);
