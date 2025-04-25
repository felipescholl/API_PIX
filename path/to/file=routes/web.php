<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CobrancasController;
use App\Http\Controllers\ClientesController;

// Outras rotas...

// Rotas de recurso para Cobrancas
Route::resource('cobrancas', CobrancasController::class);

// Rotas de recurso para Clientes
Route::resource('clientes', ClientesController::class); 