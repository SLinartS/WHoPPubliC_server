<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ZoneController;
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

// MAP
Route::get('/map', [ZoneController::class, 'index']);

// PRODUCTS
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{taskId}', [ProductController::class, 'getProductsOfTask']);

// TASKS
Route::get('/tasks/{type}', [TaskController::class, 'index']);


// Route::get('/test', [TaskController::class, 'test']);
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
