<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OnboardingController;

/*
|--------------------------------------------------------------------------
| Rotas Web
|--------------------------------------------------------------------------
|
| Estrutura:
| - / → Landing page pública
| - /app/{tenant} → Painel Filament das empresas (gerenciado pelo Filament)
| - /meuadmin → Painel do super admin (gerenciado pelo Filament)
|
*/

// Rota raiz - Landing page ou redirecionamento
Route::get('/', function () {
    // Se não logado, mostra landing page pública
    if (!Auth::check()) {
        return view('landing');
    }

    // Se logado mas não tem empresa, manda criar
    if (!Auth::user()->hasCompany()) {
        return redirect()->route('filament.app.tenant.registration');
    }

    // Se logado e tem empresa, redireciona para o painel da primeira empresa
    $company = Auth::user()->companies()->first();
    return redirect("/app/{$company->slug}");
});

// Grupo protegido por autenticação
Route::middleware(['auth'])->group(function () {
    Route::get('/new-company', [OnboardingController::class, 'create'])->name('company.create');
    Route::post('/new-company', [OnboardingController::class, 'store'])->name('company.store');
});
