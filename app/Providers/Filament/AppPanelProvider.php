<?php

namespace App\Providers\Filament;

use App\Filament\App\Pages\EditProfile;
use App\Models\Company;
use App\Filament\App\Pages\Tenancy\RegisterCompany;
use App\Filament\App\Pages\Tenancy\EditCompanyProfile;
use App\Http\Middleware\EnsureUserHasCompany;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('app')
            ->path('')
            ->tenantDomain('{tenant:slug}.' . config('app.domain'))
            ->login()
            ->passwordReset()
            ->registration()
            ->darkMode(false) // Desativa o Dark Mode
            ->profile(EditProfile::class)
            ->tenant(
                Company::class, slugAttribute: 'slug')
            ->tenantRegistration(RegisterCompany::class)
            ->tenantProfile(EditCompanyProfile::class)

            // Logo dinâmica baseada no tenant
            ->brandLogo(fn () => $this->getTenantLogo())
            ->brandLogoHeight('2.5rem')

            // Logo no mobile (entre hamburger e notificações)
            ->renderHook(
                'panels::topbar.start',
                fn () => $this->renderMobileLogo()
            )

            // Centro de notificações (sininho)
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')

            // Sidebar colapsável no desktop
            ->sidebarCollapsibleOnDesktop()

            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/App/Resources'), for: 'App\Filament\App\Resources')
            ->discoverPages(in: app_path('Filament/App/Pages'), for: 'App\Filament\App\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/App/Widgets'), for: 'App\Filament\App\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                EnsureUserHasCompany::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }

    /**
     * Retorna a logo do tenant atual ou o nome do app como fallback.
     */
    protected function getTenantLogo(): string|\Illuminate\Contracts\Support\Htmlable|null
    {
        $tenant = filament()->getTenant();

        if ($tenant && $tenant->logo_url) {
            return $tenant->logo_url;
        }

        // Fallback: retorna o nome do app (será exibido como texto)
        return null;
    }

    /**
     * Renderiza a logo no topbar mobile.
     */
    protected function renderMobileLogo(): \Illuminate\Contracts\Support\Htmlable|string
    {
        $tenant = filament()->getTenant();

        if (!$tenant || !$tenant->logo_url) {
            return '';
        }

        return new \Illuminate\Support\HtmlString(
            '<img src="' . e($tenant->logo_url) . '" alt="Logo" class="h-8 md:hidden ml-2" style="max-width: 120px; object-fit: contain;" />'
        );
    }
}
