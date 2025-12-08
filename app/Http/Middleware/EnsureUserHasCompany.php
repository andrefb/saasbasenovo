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

        // Se não logado, deixa passar (vai cair no auth middleware depois)
        if (!$user) {
            return $next($request);
        }

        // Se o usuário tem empresa, deixa passar
        if ($user->hasCompany()) {
            return $next($request);
        }

        // Evitar Loop Infinito: se já está na página de criar empresa, deixa passar
        if ($request->routeIs('filament.app.tenant.registration') || $request->routeIs('company.create')) {
            return $next($request);
        }

        // Não tem empresa -> Redireciona para criação
        return redirect()->route('filament.app.tenant.registration');
    }
}
