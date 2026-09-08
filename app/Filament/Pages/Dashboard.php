<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard';

    protected static ?string $navigationLabel = 'Dashboard';

    // 🌟 SANGAT PENTING: Ubah tipe data kembalian menjadi hanya array|int
    public function getColumns(): array | int
    {
        return 1;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // \App\Filament\Widgets\DashboardOverview::class,
            // \App\Filament\Widgets\BlogPostsChart::class,
        ];
    }
}