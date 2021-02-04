<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LinkController;
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
Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/logout', [AuthController::class, 'logout']);

    Route::post('/link/store', [LinkController::class, 'store']);

    Route::delete('/link/{id}', [LinkController::class, 'destroy']);

    Route::get('/links', [LinkController::class, 'index']);


});

Route::post('/go/',[LinkController::class,'link']);

