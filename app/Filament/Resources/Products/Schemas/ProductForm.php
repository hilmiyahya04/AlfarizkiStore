<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('productCode')
                    ->required(),
                TextInput::make('productName')
                    ->required(),
                TextInput::make('productCompany'),
                TextInput::make('productPrice')
                    ->required()
                    ->numeric(),
                FileUpload::make('productImage1')
                    ->image()
                    ->disk('public')
                    ->directory('product')
                    ->imagePreviewHeight('100')
                    ->preserveFilenames(),
                TextInput::make('productAvailability'),
                DatePicker::make('postingDate'),

                Select::make('categoryId')
                    ->relationship('category', 'categoryName')
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->default(null),

                Repeater::make('variants')
                    ->relationship('variants')
                    ->schema([
                        Select::make('size')
                            ->options([
                                'S' => 'S',
                                'M' => 'M',
                                'L' => 'L',
                                'XL' => 'XL',
                                'XXL' => 'XXL',
                            ])
                            ->required(),
                        Select::make('color')
                            ->options([
                                'Merah' => 'Merah',
                                'Biru' => 'Biru',
                                'Hitam' => 'Hitam',
                                'Putih' => 'Putih',
                                // sesuaikan dengan warna yang kamu pakai
                            ])
                            ->required(),
                        TextInput::make('material'),
                    ])
                    ->columns(3)
                    ->addActionLabel('Tambah Varian')
                    ->defaultItems(1)
                    ->columnSpanFull(),
            ]);
    }
}