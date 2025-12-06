<?php

namespace App\Http\Responses;

use Filament\Auth\Http\Responses\Contracts\LogoutResponse as LogoutResponseContract;
use Illuminate\Http\RedirectResponse;

class LogoutResponse implements LogoutResponseContract
{
    public function toResponse($request): RedirectResponse
    {
        // Debug - vamos ver se está sendo chamado
        \Log::info('LogoutResponse::toResponse chamado', ['host' => $request->getHost()]);
    
        // Redireciona para o domínio principal (sem subdomínio do tenant)
        $scheme = $request->secure() ? 'https' : 'http';
        $domain = config('app.domain');
        $port = $request->getPort();
        
        // Em produção normalmente não precisa da porta
        $portSuffix = in_array($port, [80, 443]) ? '' : ':' . $port;
        
        $url = "{$scheme}://{$domain}{$portSuffix}/?logout=1";
        
        \Log::info('LogoutResponse redirecionando para', ['url' => $url]);
        
        return redirect($url);
    }
}
