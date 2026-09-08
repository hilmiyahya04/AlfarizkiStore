<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use App\Filament\Pages\Dashboard;
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
use App\Filament\Widgets\DashboardOverview;
use App\Filament\Widgets\BlogPostsChart;
use App\Filament\Widgets\OrderStats;
use App\Http\Responses\CustomLoginResponse;
use App\Http\Responses\CustomRegistrationResponse;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Http\Responses\Contracts\RegistrationResponse;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            // ->viteTheme('resources/css/filament/admin/theme.css')
            ->brandName('Alfarizki')
            ->login()
            ->registration()
            ->globalSearch(false) 
            ->databaseNotifications()
            ->sidebarCollapsibleOnDesktop()
            ->colors([
            'primary' => '240, 240, 240',   
                100 => '220, 220, 220',
                200 => '180, 180, 180',
                300 => '130, 130, 130',
                400 => '70, 70, 70',
                500 => '0, 0, 0',       // Warna utama tombol (Hitam Pekat)
                600 => '30, 30, 30',     // Warna saat tombol di-hover
                700 => '20, 20, 20',
                800 => '15, 15, 15',
                900 => '10, 10, 10',
                950 => '5, 5, 5', 
                'danger' => Color::Rose,
                'success' => Color::Emerald,
                'warning' => Color::Amber,
                'info' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            // ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                \App\Filament\Widgets\WelcomeBanner::class,
                DashboardOverview::class,
                OrderStats::class,
                BlogPostsChart::class,
            ])

            ->bootUsing(function () {
                app()->bind(LoginResponse::class, CustomLoginResponse::class);
                app()->bind(RegistrationResponse::class, CustomRegistrationResponse::class);
            })
            
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
            ->spa()
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
            ]);
    }
}
