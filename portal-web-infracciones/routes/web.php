<?php

use App\Http\Controllers\InfraccionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Ruta de prueba para verificar que Inertia carga la página Auth/Login
Route::get('/test-login', function () {
    return Inertia::render('Auth/Login');
});

// Ruta pública temporal para ver la vista del Supervisor (vistasuper.vue)
Route::get('/supervisor', function () {
    return Inertia::render('vistasuper');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // La página del formulario
    Route::get('/consulta-infracciones', [InfraccionController::class, 'index'])->name('infracciones.index');

    // CAMBIO AQUÍ: De post a get
    Route::get('/consulta-infracciones/buscar', [InfraccionController::class, 'buscar'])->name('infracciones.buscar');

    // Panel oficial / agente
    Route::get('/panel-oficial', function () {
        return Inertia::render('Oficial/VistaOficial');
    })->name('oficial.panel');
});
