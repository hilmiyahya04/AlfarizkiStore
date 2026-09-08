<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Events\Login;
use App\Listeners\MigrateGuestCartOnLogin;
use App\Models\CartItem;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($this->app->environment('production') || config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        // Perbaikan cart count (cookie & database, bukan session)
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');
            } else {
                $guestCart = json_decode(request()->cookie('guest_cart'), true) ?? [];
                $cartCount = array_sum(array_column($guestCart, 'quantity'));
            }
            $view->with('cartCount', $cartCount);
        });

        // Register listener migrasi cart saat login
        Event::listen(
            Login::class,
            MigrateGuestCartOnLogin::class,
        );
    }
}
