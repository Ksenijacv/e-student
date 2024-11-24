<?php

use App\Http\Controllers\UcenikController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\RoditeljController;
use App\Http\Controllers\OcenaController;
use App\Http\Controllers\PredmetController;

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

Route::post('/register',[AuthController::class,'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::get('/profesori', [ProfesorController::class, 'index']);
Route::get('/ucenici', [UcenikController::class, 'index']);
Route::get('/roditelji', [RoditeljController::class, 'index']);
Route::get('/ocene', [OcenaController::class, 'index']);
Route::get('/predmeti', [PredmetController::class, 'index']);
