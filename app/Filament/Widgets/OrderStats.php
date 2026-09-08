<?php

namespace App\Filament\Widgets;

use App\Models\orders;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class OrderStats extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();

        // Query dasar: super_admin lihat semua, user lain cuma lihat order miliknya
        $query = orders::query()
            ->when(
                ! $user->hasRole('super_admin'),
                fn ($query) => $query->where('userId', $user->id)
            );

        return [

            Stat::make(
                'Sedang Diproses',
                (clone $query)->where('orderStatus', 'Proses')->count()
            ),

            Stat::make(
                'Sedang Dikirim',
                (clone $query)->where('orderStatus', 'Kirim')->count()
            ),

            Stat::make(
                'Selesai',
                (clone $query)->where('orderStatus', 'Selesai')->count()
            ),

            Stat::make(
                'Dibatalkan',
                (clone $query)->where('orderStatus', 'Batal')->count()
            ),

        ];
    }
}