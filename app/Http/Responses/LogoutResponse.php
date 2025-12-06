<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;
use Illuminate\Http\RedirectResponse;

class LogoutResponse implements LogoutResponseContract
{
    public function toResponse($request): RedirectResponse
    {
        // Redireciona para o domínio principal (sem subdomínio do tenant)
        $scheme = $request->secure() ? 'https' : 'http';
        $domain = config('app.domain');
        $port = $request->getPort();
        
        // Em produção normalmente não precisa da porta
        $portSuffix = in_array($port, [80, 443]) ? '' : ':' . $port;
        
        $url = "{$scheme}://{$domain}{$portSuffix}/login";
        
        return redirect($url);
    }
}
