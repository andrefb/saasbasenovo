<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OnboardingController;

Route::get('/', function () {
    return view('welcome');
});



// Grupo protegido por autenticação (só acessa se tiver logado)
Route::middleware(['auth'])->group(function () {
    Route::get('/new-company', [OnboardingController::class, 'create'])->name('company.create');
    Route::post('/new-company', [OnboardingController::class, 'store'])->name('company.store');
});
