<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class WelcomeBanner extends Widget
{
    protected string $view = 'filament.widgets.welcome-banner';

    // 🌟 UBAH BAGIAN INI MENJADI 'full'
    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return Auth::check() && Auth::user()->hasRole('customer');
    }
}