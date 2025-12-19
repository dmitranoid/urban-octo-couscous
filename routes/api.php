<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::get('/page/{page}/block/{block:slug}', [\App\Http\Controllers\api\BlockController::class, 'byPageAndSlug']);
Route::get('/page/{page}/blocks', [\App\Http\Controllers\api\PageController::class, 'blocks']);
Route::get('/page/{page:slug}', [\App\Http\Controllers\api\PageController::class, 'bySlug']);
Route::get('/block/{element:slug}', [\App\Http\Controllers\api\BlockController::class, 'bySlug']);
Route::get('/image/{element:slug}', [\App\Http\Controllers\api\ImageController::class, 'bySlug']);
//Route::get('/images/{element:slug}', [\App\Http\Controllers\ImagesController::class, 'bySlug']);


Route::get('/manufacturers/top', [\App\Http\Controllers\api\ManufacturerController::class, 'top']);
Route::get('/manufacturers/byslug/{slug}', [\App\Http\Controllers\api\ManufacturerController::class, 'bySlug']);
//Route::get('/manufacturers/{id}/categories', \App\Http\Controllers\CategoryController::class, [''])->only(['index', 'show']);
Route::get('/manufacturers/menu', [\App\Http\Controllers\api\ManufacturerController::class, 'menu']);
Route::apiResource('/manufacturers', \App\Http\Controllers\api\ManufacturerController::class)->only(['index', 'show']);

Route::get('/products/top', [\App\Http\Controllers\api\ProductController::class, 'top']);
Route::get('/products/search', [\App\Http\Controllers\api\ProductController::class, 'search']);
Route::get('/products/byslug/{slug}', [\App\Http\Controllers\api\ProductController::class, 'bySlug']);
Route::get('/products/{id}/related', [\App\Http\Controllers\api\ProductController::class, 'related']);
Route::apiResource('/products', \App\Http\Controllers\api\ProductController::class)->only(['index', 'show']);

Route::get('/categories/top', [\App\Http\Controllers\api\CategoryController::class, 'top']);
Route::get('/categories/byslug/{slug}', [\App\Http\Controllers\api\CategoryController::class, 'bySlug']);
Route::apiResource('/categories', \App\Http\Controllers\api\CategoryController::class)->only(['index', 'show']);

Route::apiSingleton('/basket', \App\Models\BasketProduct::class);
    // ->middleware(); // only authorised users

Route::post('/order/product/', [\App\Http\Controllers\api\OrderController::class, 'addProduct']);
Route::put('/order/product/{id}', [\App\Http\Controllers\api\OrderController::class, 'updateProduct']);
Route::delete('/order/product/', [\App\Http\Controllers\api\OrderController::class, 'deleteProduct']);

Route::apiSingleton('/order', \App\Http\Controllers\api\OrderController::class)->only(['get', 'put']);

Route::post('/messages/contact/', [\App\Http\Controllers\api\MessageController::class, 'storeContact']);
Route::post('/messages/question/', [\App\Http\Controllers\api\MessageController::class, 'storeQuestion']);
Route::post('/messages/pricerequest/', [\App\Http\Controllers\api\MessageController::class, 'storePrice']);

Route::get('/search', [\App\Http\Controllers\api\ProductController::class, 'search'])->name('search');

Route::get('/settings/{section}', [\App\Http\Controllers\api\SettingsController::class, 'bySection'])->name('settings');

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/