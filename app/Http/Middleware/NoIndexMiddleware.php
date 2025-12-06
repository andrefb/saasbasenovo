<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoIndexMiddleware
{
    /**
     * Adiciona headers para prevenir indexação por search engines.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Header que diz aos crawlers para não indexar
        $response->headers->set('X-Robots-Tag', 'noindex, nofollow, noarchive');

        return $response;
    }
}
