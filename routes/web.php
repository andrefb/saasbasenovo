<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OnboardingController;

// Rota raiz - mostra landing page ou redireciona baseado no estado
Route::get('/', function () {
    $host = request()->getHost();
    $domain = config('app.domain');
    
    // Se é o domínio raiz (sem subdomínio), mostra landing page pública
    if ($host === $domain) {
        return view('landing');
    }
    
    // Se tem subdomínio, comportamento do tenant
    // Se não está logado, vai para login
    if (!Auth::check()) {
        return redirect('/login');
    }
    
    // Se está logado mas não tem empresa, vai criar empresa
    if (!Auth::user()->hasCompany()) {
        return redirect('/new');
    }
    
    // Se tem empresa, pega a primeira e redireciona pro subdomínio dela
    $company = Auth::user()->companies()->first();
    $scheme = request()->secure() ? 'https' : 'http';
    $port = request()->getPort();
    $portSuffix = in_array($port, [80, 443]) ? '' : ':' . $port;
    
    return redirect("{$scheme}://{$company->slug}.{$domain}{$portSuffix}");
});



// Grupo protegido por autenticação (só acessa se tiver logado)
Route::middleware(['auth'])->group(function () {
    Route::get('/new-company', [OnboardingController::class, 'create'])->name('company.create');
    Route::post('/new-company', [OnboardingController::class, 'store'])->name('company.store');
});
