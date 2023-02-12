<?php


use App\Http\Controllers\ProductController;
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

Route::resource('products', ProductController::class);
Route::get('/products/{id}', [ProductController::class, 'findById']);
Route::get('/products/search/name-and-category', [ProductController::class, 'searchByNameAndCategory']);
Route::get('/products/search/category', [ProductController::class, 'searchByCategory']);
Route::get('/products/search/image', [ProductController::class, 'searchByImage']);
