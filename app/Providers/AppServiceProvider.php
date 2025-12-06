<?php

namespace App\Providers;

use App\Http\Responses\LogoutResponse;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;
use Filament\Tables\Table;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Customiza o redirect após logout para ir ao domínio principal
        $this->app->singleton(LogoutResponseContract::class, LogoutResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Table::configureUsing(function (Table $table): void {
        $table
            ->defaultDateDisplayFormat('d/m/Y')
            ->defaultDateTimeDisplayFormat('d/m/Y H:i');
    });
    }
}
