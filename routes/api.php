<?php

use Illuminate\Support\Facades\Route;
use Yomo7\Whami\Http\Controllers\WhamiController;

/*
|--------------------------------------------------------------------------
| Whami API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for the Whami package.
|
*/

Route::post('/process', [WhamiController::class, 'processKeyword']);
Route::get('/number/{number}', [WhamiController::class, 'getKeywordsByNumber']);
Route::get('/attribution/{attributionCode}', [WhamiController::class, 'getKeywordsByAttributionCode']);
