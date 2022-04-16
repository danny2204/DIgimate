<?php

use App\Http\Controllers\BundleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProductController;

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

Route::get('/getProduct/{SKU}', [ProductController::class, 'showProduct']);
Route::get('/getAllProduct/', [ProductController::class, 'showAllProduct']);
Route::get('/getAllBundle/', [BundleController::class, 'getAllBundle']);
Route::get('/getBundle/{SKU}', [BundleController::class, 'showBundle']);
Route::post('/addNewProduct/', [ProductController::class, 'addNewProduct']);
Route::post('/updateProduct/{SKU}', [ProductController::class, 'updateProduct']);
Route::post('/updateBundle/{SKU}', [BundleController::class, 'updateBundle']);
Route::post('/deleteProduct/{SKU}', [ProductController::class, 'deleteProduct']);
Route::post('/deleteBundle/{SKU}', [BundleController::class, 'deleteBundle']);
Route::post('/addBundle/', [BundleController::class, 'addBundle']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
