<?php

use App\Http\Controllers\UcenikController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\RoditeljController;
use App\Http\Controllers\OcenaController;
use App\Http\Controllers\PredmetController;


Route::post('/register',[AuthController::class,'register']);
Route::post('/login', [AuthController::class, 'login']);

//da se prilikom registracije poziva i ovo kreiranje
Route::post('/profesor', [ProfesorController::class, 'store']);
Route::post('/ucenik', [UcenikController::class, 'store']);
Route::post('/roditelj', [RoditeljController::class, 'store']);

//prikaz 
Route::get('/profesori', [ProfesorController::class, 'index']);
Route::get('/ucenici', [UcenikController::class, 'index']);
Route::get('/roditelji', [RoditeljController::class, 'index']);
Route::get('/ocene', [OcenaController::class, 'index']);
Route::get('/predmeti', [PredmetController::class, 'index']);

//zasticena grupna ruta
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/ucenici/{id}', [UcenikController::class, 'show']);
    Route::put('/ucenici/{id}', [UcenikController::class, 'update']);

    Route::get('/roditelji/{id}', [RoditeljController::class, 'show']);
    Route::put('/roditelji/{id}', [RoditeljController::class, 'update']);

    Route::get('/profesori/{id}', [ProfesorController::class, 'show']);
    Route::put('/profesori/{id}', [ProfesorController::class, 'update']);
    Route::post('/profesori/dodaj-predmet', [ProfesorController::class, 'dodajPredmet']);
    Route::delete('/profesori/ukloni-predmet/{predmet_id}', [ProfesorController::class, 'ukloniPredmet']);

    Route::get('/predmeti/dostupni', [PredmetController::class, 'dostupniPredmeti']);

    //za admina - sta sve radi
    Route::get('/metrics', [PredmetController::class, 'getMetricsForAdmin']);
    Route::resource('predmeti', PredmetController::class)->only([
        'store', 'update']);
    Route::patch('/predmeti/{id}/ukloni-profesora', [PredmetController::class, 'ukloniProfesora']);

    Route::get('/ocene/moje', [OcenaController::class, 'vratiMojeOcene']);
    Route::get('/ocene/moje-dece', [OcenaController::class, 'vratiOceneMojeDece']);

    Route::post('/logout', [AuthController::class, 'logout']);

});  