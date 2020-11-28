<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/registro', 'ApiAuth\AuthController@registro');
Route::post('/login', 'ApiAuth\AuthController@logIn');
Route::middleware('auth:sanctum')->post('/archivo','File\FileController@guardarArchivo');
Route::middleware('auth:sanctum')->get('/descarga','File\FileController@descargaArchivo');
Route::middleware('auth:sanctum')->post('/comentario','ApiAuth\AuthController@guardarComentario');