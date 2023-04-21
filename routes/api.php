<?php

use App\Http\Controllers\TareaController;
use Illuminate\Http\Request;
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

Route::put('tarea/{tareaId}/restore', [TareaController::class, 'restore']);
Route::patch('tarea/{tarea}/estado-hecha/{hecha}', [TareaController::class, 'cambiarhecha'])->name('tarea.estado.hecha');
Route::apiResource('tarea', TareaController::class);
