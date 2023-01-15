<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\PerfomanceReportController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\UtilsController;
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

// CATEGORIES
Route::get('/categories', [CategoryController::class, 'index']);

// MAP
Route::get('/map', [MapController::class, 'index']);
Route::get('/points', [PointController::class, 'index']);

// PRODUCTS
Route::get('/products', [ProductController::class, 'index']);
Route::get('/productinfo/{productId}', [ProductController::class, 'show']);
Route::post('/products', [ProductController::class, 'store']);
Route::delete('/products/{productId}', [ProductController::class, 'destroy']);
Route::put('/products', [ProductController::class, 'update']);

// TASKS
Route::get('/tasks/{type}', [TaskController::class, 'index']);
Route::get('/taskinfo/{taskId}', [TaskController::class, 'show']);
Route::post('/tasks', [TaskController::class, 'create']);
Route::delete('/tasks/{taskId}', [TaskController::class, 'destroy']);
Route::put('/tasks', [TaskController::class, 'update']);

// ADDITIVE CRITERION
Route::get('/perfomance-report', [PerfomanceReportController::class, 'index']);

// OTHER
Route::get('/check-article/{type}/{article}', [UtilsController::class, 'checkArticle']);
