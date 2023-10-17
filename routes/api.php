<?php

use App\Http\Controllers\Api\ChartController;
use App\Http\Controllers\Api\CsvController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ReportController;
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


Route::get('/csrf-token', function() {
    return response()->json([
        'token' => csrf_token()
    ]);
});

Route::controller(UserController::class)->group(function(){
    Route::post('/login', 'login')->middleware('guest');
    Route::get('/user', 'getUser');
    Route::get('/get-users', 'getUsers');
    Route::delete('/delete-user/{userId}', 'deleteUser');
    Route::put('/update-user/{userId}',  'updateUser');
    Route::post('/create-user', 'createUser');
    Route::post('/logout', 'destroy');
});

Route::post('/upload-csv', [CsvController::class, 'uploadCsv']);

Route::controller(ChartController::class)->group(function(){
    Route::get('/split-20m/{city}/{timeStart}/{timeEnd}', 'get20mSplit');
    Route::post('/split-daily', 'getDailySplit');
    Route::get('/range-20m/{city}', 'getSplit20mRange');
    Route::get('/range-daily', 'getSplitDailyRange');
});

Route::controller(ReportController::class)->group(function(){
    Route::get('/report/first-type', 'makeFirstTypeReport');
    Route::get('/report/xlsx', 'downloadXLSXReport');

    Route::get('/vaisala/range/stations', 'getVaisalaRange');
    Route::get('/vaisala/range', 'getVaisalaSensorRange');
});
