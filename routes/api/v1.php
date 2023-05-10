<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\PostController;
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

Route::get('/', function () {
    return response('Welcome API v1', 200);
});

Route::get('/post', [PostController::class,'index'])->middleware('verify-token');
Route::post('/post', [PostController::class,'create'])->middleware('verify-token');

Route::post('/login', [AuthController::class,'login']);
Route::get('/user', [AuthController::class,'user'])->middleware(["validate-jwt"]);
Route::get('/encode', [AuthController::class,'encode'])->middleware([]);
Route::get('/decode', [AuthController::class,'decode'])->middleware([]);