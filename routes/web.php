<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DashboardController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Esta es la línea importante:
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rutas para recetas
    Route::resource('recetas', RecetaController::class);
    Route::get('recetas/{receta}/pdf', [RecetaController::class, 'exportarPdf'])->name('recetas.pdf');
    Route::get('recetas/{receta}/compartir', [RecetaController::class, 'compartir'])->name('recetas.compartir');
    
    // Rutas para categorías
    Route::resource('categorias', CategoriaController::class);
});
