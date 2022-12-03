<?php

use App\Http\Controllers\AdditiveCriterionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\PointController;
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

// CATEGORIES
Route::get('/categories', [CategoryController::class, 'index']);

// MAP
Route::get('/map', [MapController::class, 'index']);
Route::get('/points', [PointController::class, 'index']);

// PRODUCTS
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{taskId}', [ProductController::class, 'getProductsOfTask']);
Route::post('/products', [ProductController::class, 'addProducts']);
Route::delete('/products/{productId}', [ProductController::class, 'deleteProduct']);

// TASKS
Route::get('/tasks/{type}', [TaskController::class, 'index']);
Route::post('/tasks', [TaskController::class, 'addTask']);

// ADDITIVE CRITERION
Route::get('/additive-criterion', [AdditiveCriterionController::class, 'index']);
