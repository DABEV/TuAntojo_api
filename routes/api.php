<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RepartidorController;
use App\Http\Controllers\EstablecimientoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('repartidor', RepartidorController::class);
Route::apiResource('tienda', EstablecimientoController::class);

//Api de usuarios 
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ["auth:sanctum"]], function () {
    Route::get('userProfile', [AuthController::class, 'userProfile']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::put('changePassword', [AuthController::class, 'changePassword']);
});

Route::prefix('shelve')->group(function(){
    Route::get('index', [ShelveController::class, "index"]);
    Route::post('store', [ShelveController::class, "store"]);
    Route::put('update/{id}', [ShelveController::class, "update"]);
    Route::get('show/{id}', [ShelveController::class, "show"]);
    Route::delete('destroy/{id}', [ShelveController::class, "destroy"]);
});

Route::prefix('product')->group(function(){
    Route::get('index', [ProductController::class, "index"]);
    Route::post('store', [ProductController::class, "store"]);
    Route::put('update/{id}', [ProductController::class, "update"]);
    Route::get('show/{id}', [ProductController::class, "show"]);
    Route::delete('destroy/{id}', [ProductController::class, "destroy"]);
});