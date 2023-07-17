<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CourseController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('category')->group(function () {
    Route::get('/', [CategoryController::class, 'list']);
    Route::post('/edit/{id}', [CategoryController::class, 'update']);
    // Route::get('/{id}', [CategoryController::class, 'getDetail']);
    Route::post('/create', [CategoryController::class, 'store']);
    Route::delete('/delete/{id}', [CategoryController::class, 'destroy']);
});

Route::prefix('course')->group(function () {
    Route::get('/', [CourseController::class, 'list']);
    Route::post('/edit/{id}', [CourseController::class, 'update']);
    // Route::get('/{id}', [CourseController::class, 'getDetail']);
    Route::post('/create', [CourseController::class, 'store']);
    Route::delete('/delete/{id}', [CourseController::class, 'destroy']);
});

