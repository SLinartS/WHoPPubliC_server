<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\PerfomanceReportController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\RoleController;
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

// POINTS
Route::get('/points', [PointController::class, 'index']);

// ROLES
Route::get('/roles', [RoleController::class, 'index']);


// MAP
Route::get('/map', [MapController::class, 'index']);
Route::put('/map', [MapController::class, 'update']);
Route::delete('/map/{zoneId}', [MapController::class, 'destroy']);

// PRODUCTS
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{productId}', [ProductController::class, 'show']);
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products', [ProductController::class, 'update']);
Route::delete('/products/{productId}', [ProductController::class, 'destroy']);


Route::patch('/products/markAsMoved', [ProductController::class, 'markAsMoved']);

// TASKS
Route::get('/tasks', [TaskController::class, 'index']);
Route::get('/tasks/{taskId}', [TaskController::class, 'show']);
Route::post('/tasks', [TaskController::class, 'create']);
Route::put('/tasks', [TaskController::class, 'update']);
Route::delete('/tasks/{taskId}', [TaskController::class, 'destroy']);


// ACCOUNTS
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);


// ADDITIVE CRITERION
Route::get('/perfomance-report', [PerfomanceReportController::class, 'index']);

// GENERATE
Route::get('/generate/article/{type}', [UtilsController::class, 'generateArticle']);
Route::get('/generate/zoneletter', [UtilsController::class, 'generateZoneLetter']);
