<?php

namespace App\Http\Responses;

use Filament\Auth\Http\Responses\Contracts\LogoutResponse as LogoutResponseContract;
use Illuminate\Http\RedirectResponse;

class LogoutResponse implements LogoutResponseContract
{
    public function toResponse($request): RedirectResponse
    {
        // Sempre redireciona para a raiz da aplicação (landing page)
        $appUrl = config('app.url');
        return redirect($appUrl . '/?logout=1');
    }
}
