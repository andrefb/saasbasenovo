<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasCompany
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // 1. Ignora se não logado ou se está acessando o domínio base (painel admin)
        if (! $user || $request->getHost() === config('app.domain')) {
            return $next($request);
        }

        // 2. Verifica se o usuário tem alguma empresa
        if (! $user->hasCompany()) {

            // 3. IMPORTANTE: Evitar Loop Infinito
            // Se ele já estiver na página de criar empresa (admin ou site), DEIXA PASSAR.
            if ($request->routeIs('filament.app.tenant.registration') || $request->routeIs('company.create') || $request->routeIs('company.store')) {
                return $next($request);
            }

            // 4. Se não tem empresa e tá tentando acessar o dashboard -> Redireciona para criação manual (sem subdomínio)
            return redirect()->route('company.create');
        }

        return $next($request);
    }
}
