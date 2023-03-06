<?php

use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\PerformanceReportController;
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


// AUTHORIZATION

Route::post('/login', [AuthorizationController::class, 'login']);
Route::post('/refresh', [AuthorizationController::class, 'refresh']);
Route::post('/logout', [AuthorizationController::class, 'logout']);

Route::middleware(['jwt'])->group(function () {
  Route::controller(MapController::class)->group(function () {
    Route::get('/map', 'index');
    Route::put('/map', 'update');
    Route::delete('/map/{zoneId}', 'destroy');
  });

  Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index');
    Route::get('/products/{productId}', 'show');
    Route::post('/products', 'store');
    Route::put('/products', 'update');
    Route::delete('/products/{productId}', 'destroy');

    Route::post('/products-add-image', 'addImage');
    Route::patch('/products/markAsMoved', 'markAsMoved');
  });

  Route::controller(TaskController::class)->group(function () {
    Route::get('/tasks', 'index');
    Route::get('/tasks/{taskId}', 'show');
    Route::post('/tasks', 'create');
    Route::put('/tasks', 'update');
    Route::delete('/tasks/{taskId}', 'destroy');
  });

  Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'index');
    Route::get('/users/{id}', 'show');
    Route::post('/users', 'store');
    Route::put('/users', 'update');
    Route::delete('/users/{id}', 'destroy');
  });

  Route::controller(PerformanceReportController::class)->group(function () {
    Route::get('/performance-report', 'index');
    Route::post('/performance-report', 'store');
    Route::get('/performance-report/{id}', 'download');
    Route::delete('/performance-report/{id}', 'destroy');
  });

  Route::get('/categories', [CategoryController::class, 'index']);
  Route::get('/points', [PointController::class, 'index']);
  Route::get('/roles', [RoleController::class, 'index']);

  Route::get('/generate/article/{type}', [UtilsController::class, 'generateArticle']);
  Route::get('/generate/zone-letter', [UtilsController::class, 'generateZoneLetter']);
});
