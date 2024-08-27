<?php

use App\Http\Controllers\EntidadController;
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

Route::get('/', [EntidadController::class, 'index']);
Route::post('/extraer-entidades', [EntidadController::class, 'extraerEntidades']);
