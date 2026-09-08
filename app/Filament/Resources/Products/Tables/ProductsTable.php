<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\DeleteAction;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('productCode')
                    ->label('Kode Produk')
                    ->searchable(),
                TextColumn::make('productName')
                    ->label('Nama Produk')
                    ->searchable(),
                TextColumn::make('productCompany')
                    ->label('Perusahaan Produk')
                    ->searchable(),
                TextColumn::make('productPrice')
                    ->label('Harga Produk')
                    ->numeric()
                    ->sortable(),
                ImageColumn::make('productImage1')
                    ->label('Gambar Produk')
                    ->disk('public'),
                TextColumn::make('productAvailability')
                    ->label('Ketersediaan Produk')
                    ->searchable(),
                TextColumn::make('postingDate')
                    ->label('Tanggal Posting')
                    ->dateTime(),
                TextColumn::make('categoryId')
                    ->label('Kategori')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('variants.size')
                    ->label('Ukuran')
                    ->searchable(),
                TextColumn::make('variants.color')
                    ->label('Warna')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actionsColumnLabel('Aksi')
            ->actions([
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
                    ->tooltip('Delete Produk'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Delete Produk'),
                ]),
            ]);
    }
}
