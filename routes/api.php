<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Rotas públicas
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::apiResource('categorias', CategoriaController::class)->only(['index', 'show']);
Route::apiResource('autores', AutorController::class)->only(['index', 'show'])
    ->parameters(['autores' => 'autor']);
Route::apiResource('livros', LivroController::class)->only(['index', 'show']);

// Rotas protegidas (Sanctum)
Route::middleware('auth:sanctum')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/user', [AuthController::class, 'me'])->name('user');

    Route::apiResource('categorias', CategoriaController::class)->except(['index', 'show']);
    Route::apiResource('autores', AutorController::class)->except(['index', 'show'])
        ->parameters(['autores' => 'autor']);
    Route::apiResource('livros', LivroController::class)->except(['index', 'show']);

    Route::apiResource('users', UserController::class)->except(['store']);
});
