<?php

namespace App\Filament\Resources\ProductVariants\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use App\Models\Product;


class ProductVariantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
       Select::make('productId')
            ->label('Produk')
            ->options(
                \App\Models\Product::query()->pluck('productName', 'id')
            )
            ->searchable()
            ->preload()
            ->required(),

        Select::make('size')
            ->label('Ukuran')
            ->options([
                'S' => 'Small',
                'M' => 'Medium',
                'L' => 'Large',
                'XL' => 'XL',
            ])
            ->required(),

        Select::make('color')
            ->label('Warna')
            ->options([
                'Merah' => 'Merah',
                'Biru' => 'Biru',
                'Hijau' => 'Hijau',
                'Hitam' => 'Hitam',
                'Putih' => 'Putih',
            ])
            ->required(),

        TextInput::make('material')
            ->label('Bahan')
            ->required(),
            ]);
    }
}
