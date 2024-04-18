<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use App\Filament\Auth\Login;
use App\Filament\Widgets\menuGrid;
use Filament\Support\Colors\Color;
use Filament\Navigation\NavigationGroup;
use App\Filament\Widgets\CustomMenuWidget;
use Filament\Http\Middleware\Authenticate;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Swis\Filament\Backgrounds\ImageProviders\Triangles;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Swis\Filament\Backgrounds\FilamentBackgroundsPlugin;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Edwink\FilamentUserActivity\FilamentUserActivityPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use SolutionForest\FilamentSimpleLightBox\SimpleLightBoxPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()    
            ->id('app')
            ->path('')
            ->login(Login::class)
            ->darkMode(false)
            ->brandName('PPAK')
            ->brandLogo(asset('images/brand.png'))
            ->brandLogoHeight('3rem')
            ->profile()
            ->topNavigation()
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Pegawai')
                    ->icon('heroicon-s-user-group'),
                NavigationGroup::make()
                    ->label('Pengaturan')
                    ->icon('heroicon-s-cog-6-tooth'),
            ])
            ->favicon(asset('images/favicon.png'))
            ->sidebarCollapsibleOnDesktop()
            ->colors([
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Blue,
                'primary' => Color::Indigo,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                //Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                //Widgets\FilamentInfoWidget::class            
            ])
            ->breadcrumbs(false)
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
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->resources([
                config('filament-logger.activity_resource')
            ])
            ->plugins([
                BreezyCore::make(),
                FilamentShieldPlugin::make(),
                FilamentBackgroundsPlugin::make()
                    ->imageProvider(Triangles::make()),
                SimpleLightBoxPlugin::make(),
                FilamentUserActivityPlugin::make(),
            ])
            ->unsavedChangesAlerts()
            //->spa()
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s');
    }
}
