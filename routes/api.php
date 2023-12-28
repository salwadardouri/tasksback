<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

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

Route::get('/gettasks', [TaskController::class, 'index']);
Route::post('/createtasks', [TaskController::class, 'store']);
Route::delete('/deletetasks/{id}', [TaskController::class, 'destroy']);
Route::put('/updatetasks/{id}', [TaskController::class, 'update']);
Route::get('/gettasks/{id}', [TaskController::class, 'getById']);