<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OnboardingController;

// Redireciona raiz para o painel Filament (ele cuida do tenant)
Route::get('/', function () {
    return redirect('/login');
});



// Grupo protegido por autenticação (só acessa se tiver logado)
Route::middleware(['auth'])->group(function () {
    Route::get('/new-company', [OnboardingController::class, 'create'])->name('company.create');
    Route::post('/new-company', [OnboardingController::class, 'store'])->name('company.store');
});
