<?php

namespace App\Filament\Resources\ProductVariants\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;


class ProductVariantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
        TextColumn::make('id')
            ->label('No')
            ->rowIndex(),

        TextColumn::make('product.productName')
            ->label('Produk')
            ->sortable()
            ->searchable(),

        TextColumn::make('size')
            ->label('Ukuran')
            ->badge()
            ->color('info')
            ->sortable()
            ->searchable(),

        TextColumn::make('color')
            ->label('Warna')
            ->badge()
            ->color('primary')
            ->sortable()
            ->searchable(),

        TextColumn::make('material')
            ->label('Bahan')
            ->sortable()
            ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                    EditAction::make()
                    ->label('')
                    ->icon('heroicon-o-pencil-square')
                    ->color('primary')
                    ->size('sm')
                    ->tooltip('Edit Produk')
                    ->modalHeading('Edit Produk')
                    ->modalSubmitActionLabel('Simpan')
                    ->modalWidth('lg'),

                DeleteAction::make()
                    ->label('')
                    ->icon('heroicon-o-trash')
                    ->color('primary')
                    ->size('sm')
                    ->tooltip('DeleteVariant'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
