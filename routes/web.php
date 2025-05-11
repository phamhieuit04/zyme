<?php

use App\Http\Controllers\EditorController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\UserController;
use Brick\Math\Exception\RoundingNecessaryException;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\AuthController;

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
	return redirect('/login');
});

// Route::get('/index', [\App\Http\Controllers\IndexController::class, 'index']);
Route::get('/demo-query', [DemoController::class, 'index']);

// /url/{params}: truyền params vào url
Route::get('/list-file/{editorId}', [DemoController::class, 'listFile']);
Route::get('/sort-user-file', [DemoController::class, 'sortUserFile']);

Route::get('/eloquent', [DemoController::class, 'eloquent']);

Route::get('/login', [AuthController::class, 'getLogin']);
Route::post('/login', [AuthController::class, 'postLogin']);

Route::group(['middleware' => 'checkLogin'], function () {
	Route::get('/index', [IndexController::class, 'index']);
	Route::get('/dashboard', function () {
		echo "Dashboard";
	});

	Route::group(['prefix' => 'users'], function () {
		Route::get('/', [UserController::class, 'index']);
		Route::get('/create', [UserController::class, 'create']);
		Route::post('/store', [UserController::class, 'store']);
		Route::get('/show/{id}', [UserController::class, 'show']);
		Route::post('/update/{id}', [UserController::class, 'update']);
		Route::post('/single-upload/{id}', [UserController::class, 'singleUpload']);
		Route::get('/show/confirm/{id}', [UserController::class, 'confirm']);
		Route::get('/multiple-upload/{userId}', [UserController::class, 'multipleUpload']);
		Route::post('/multiple-upload/upload', [UserController::class, 'executeUpload']);
		Route::get('/synchronize/{id}', [UserController::class, 'synchronize']);
	});

	Route::group(['prefix' => 'statistic'], function () {
		Route::get('/', [StatisticController::class, 'index']);
		Route::get('/paid-salary/{id}', [StatisticController::class, 'paidSalary']);
		Route::get('/export', [StatisticController::class, 'export']);
	});

	Route::group(['prefix' => 'editors'], function () {
		Route::get('/', [EditorController::class, 'index']);
		Route::post('/edit/{id}', [EditorController::class, 'update']);
		Route::get('/download/{id}', [EditorController::class, 'download']);
	});

	Route::get('/logout', [AuthController::class, 'logout']);
});