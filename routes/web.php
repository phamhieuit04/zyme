<?php

use Brick\Math\Exception\RoundingNecessaryException;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/index', [\App\Http\Controllers\IndexController::class, 'index']);
Route::get('/demo-query', [\App\Http\Controllers\DemoController::class, 'index']);

// /url/{params}: truyền params vào url
Route::get('/list-file/{editorId}', [\App\Http\Controllers\DemoController::class, 'listFile']);
Route::get('/sort-user-file', [\App\Http\Controllers\DemoController::class, 'sortUserFile']);

Route::get('/eloquent', [\App\Http\Controllers\DemoController::class, 'eloquent']);

Route::get('/login', [\App\Http\Controllers\AuthController::class, 'getLogin']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'postLogin']);

Route::group(['middleware' => 'checkLogin'], function()
{
    Route::get('/index', [\App\Http\Controllers\IndexController::class, 'index']);
    Route::get('/dashboard', function()
    {
        echo "Dashboard";
    });

    Route::group(['prefix' => 'users'], function() {
        Route::get('/', [\App\Http\Controllers\UserController::class, 'index']);
        Route::get('/create', [\App\Http\Controllers\UserController::class, 'create']);
        Route::post('/store', [\App\Http\Controllers\UserController::class, 'store']);
        Route::get('/show/{id}', [\App\Http\Controllers\UserController::class, 'show']);
        Route::post('/update/{id}', [\App\Http\Controllers\UserController::class, 'update']);
        Route::post('/single-upload/{id}', [\App\Http\Controllers\UserController::class, 'singleUpload']);
        Route::get('/show/confirm/{id}',[\App\Http\Controllers\UserController::class, 'confirm']);
        Route::get('/multiple-upload/{userId}', [\App\Http\Controllers\UserController::class, 'multipleUpload']);
    });

    Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
});