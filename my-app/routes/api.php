<?php

use App\Http\Controllers\Api\EnrollController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('enroll')->group(function () {
    Route::get('/dump-csv', [EnrollController::class, 'dumpCsv']);
});
