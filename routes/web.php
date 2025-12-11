<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\TabelaPublicaController;

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
    // Se não logado
    if (!Auth::check()) {
        // Se landing desabilitada, mostra página "Em Breve"
        if (!config('app.show_landing', true)) {
            return view('coming-soon');
        }
        // Caso contrário, mostra landing page pública
        return view('landing');
    }

    // Se logado mas não tem empresa, manda criar
    if (!Auth::user()->hasCompany()) {
        return redirect()->route('filament.app.tenant.registration');
    }

    // Se logado e tem empresa, redireciona para o painel da primeira empresa
    $company = Auth::user()->companies()->first();
    $appDomain = config('filament.app_domain');
    
    if ($appDomain) {
        return redirect("https://{$appDomain}/{$company->slug}");
    }
    return redirect("/app/{$company->slug}");
});

// Rotas de login/register no domínio principal (redirecionam para app subdomain em produção)
Route::get('/login', function () {
    $appDomain = config('filament.app_domain');
    if ($appDomain) {
        return redirect("https://{$appDomain}/login");
    }
    return redirect('/app/login');
})->name('login.redirect');

Route::get('/register', function () {
    $appDomain = config('filament.app_domain');
    if ($appDomain) {
        return redirect("https://{$appDomain}/register");
    }
    return redirect('/app/register');
})->name('register.redirect');

// Grupo protegido por autenticação
Route::middleware(['auth'])->group(function () {
    Route::get('/new-company', [OnboardingController::class, 'create'])->name('company.create');
    Route::post('/new-company', [OnboardingController::class, 'store'])->name('company.store');
});

// Rotas públicas de tenant (sem autenticação)
// Usamos /p/ (público) para evitar conflito com /app/ do Filament
Route::get('/p/{slug}/tabela', [TabelaPublicaController::class, 'show'])->name('tabela.publica');
Route::get('/p/{slug}/tabela2', [TabelaPublicaController::class, 'show2'])->name('tabela.publica2');

// Nova rota: Tabela de disponibilidade por empreendimento
Route::get('/p/{companySlug}/{developmentSlug}/tabela', [TabelaPublicaController::class, 'showDevelopmentTable'])
    ->name('tabela.empreendimento');

// Nova rota: Tabela 2 por empreendimento
Route::get('/p/{companySlug}/{developmentSlug}/tabela2', [TabelaPublicaController::class, 'showDevelopmentTable2'])
    ->name('tabela.empreendimento2');

