<?php

use App\Http\Controllers\EnderecoController;
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

Route::controller(EnderecoController::class)->group(function () {
    Route::post('/endereco/create', 'create');
    Route::get('/endereco/read/{id}', 'read');
    Route::patch('/endereco/update/{id}', 'update');
    Route::delete('/endereco/delete/{id}', 'delete');
    Route::get('/endereco/buscar-via-cep', 'buscarViaCep');
});