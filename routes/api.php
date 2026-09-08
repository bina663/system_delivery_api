<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use Laravel\Mcp\Request;

/********************
 * Rotas da API
 * Desenvolvida por: Sabrina Oliveira
 * Data: 25/05/2026
 * ******************/
/**
 * Rotas sem autenticação para acessar
*/

/* Rota para autenticação */
Route::post('/auth', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.attempt');

Route::post('/register', [AuthController::class, 'register'])
    ->middleware('throttle:5,1')
    ->name('register');


