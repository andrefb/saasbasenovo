<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     * Adiciona headers de segurança para proteção contra XSS, clickjacking, etc.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Proteção contra clickjacking (impede que o site seja carregado em iframes)
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Impede que o navegador tente adivinhar o tipo MIME
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Ativa proteção XSS do navegador
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Controla quais informações de referrer são enviadas
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Desabilita APIs do navegador que não usamos
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        // Content Security Policy (CSP)
        // Permite scripts inline (necessário para Filament/Livewire)
        $csp = implode('; ', [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval'",
            "style-src 'self' 'unsafe-inline' https://fonts.bunny.net https://fonts.googleapis.com",
            "font-src 'self' https://fonts.bunny.net https://fonts.gstatic.com data:",
            "img-src 'self' data: https: blob:",
            "connect-src 'self' ws: wss:",  // WebSocket para Livewire
            "frame-ancestors 'self'",
        ]);
        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
