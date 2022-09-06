<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MasterController;
use App\Http\Controllers\BdhController;
use App\Http\Controllers\RphController;
use App\Http\Controllers\PohonController;
use App\Http\Controllers\MapController;


Route::group(['prefix' => 'master'], function () {
    Route::get('bdh', [BdhController::class, 'index'])->name('master-bdh');
    Route::get('bdh_all', [BdhController::class, 'get_all']);
    Route::post('bdh_add', [BdhController::class, 'set_insert']);
    Route::post('bdh_del', [BdhController::class, 'set_del']);
    Route::post('bdh_edit', [BdhController::class, 'get_one']);

    Route::get('rph', [RphController::class, 'index'])->name('master-rph');
    Route::get('rph_all', [RphController::class, 'get_all']);
    Route::post('rph_add', [RphController::class, 'set_insert']);
    Route::post('rph_del', [RphController::class, 'set_del']);
    Route::post('rph_edit', [RphController::class, 'get_one']);

    Route::get('kph', [MasterController::class, 'master_kph'])->name('master-kph');
    Route::get('shift', [MasterController::class, 'master_shift'])->name('master-shift');

    Route::get('kph_json', [MasterController::class, 'master_kph_json']);
    Route::post('kph_json', [MasterController::class, 'master_kph_json']);
});

Route::group(['prefix' => 'pohon'], function () {
    Route::get('list', [PohonController::class, 'index'])->name('pohon-list');
    Route::get('qrcode', [PohonController::class, 'get_qrcode']);
    Route::get('all', [PohonController::class, 'get_all']);
    Route::post('add', [PohonController::class, 'set_insert']);
    Route::post('del', [PohonController::class, 'set_del']);
    Route::post('detail', [PohonController::class, 'get_one']);
});

Route::get('/map', [MapController::class, 'index']);
Route::get('/map_geojson', [MapController::class, 'get_geojson']);

Route::get('/', [MasterController::class, 'master_kph'])->name('master-kph');


