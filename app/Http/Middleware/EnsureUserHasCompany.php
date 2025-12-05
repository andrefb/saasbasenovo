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

        if (! $user || $request->is('admin*')) {
            return $next($request);
        }

        // 2. Verifica se o usuário tem alguma empresa
        if (! $user->hasCompany()) {

            // 3. IMPORTANTE: Evitar Loop Infinito
            // Se ele já estiver na página de criar empresa, DEIXA PASSAR.
            // Se tentarmos redirecionar quem já está lá, o navegador trava.
            if ($request->routeIs('filament.app.tenant.registration')) {
                return $next($request);
            }

            // 4. Se não tem empresa e tá tentando acessar o dashboard -> Redireciona
            return redirect()->route('filament.app.tenant.registration');
        }

        return $next($request);
    }
}
