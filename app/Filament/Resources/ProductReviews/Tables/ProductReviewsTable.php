<?php

namespace App\Filament\Resources\ProductReviews\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class ProductReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('product.productName')
                    ->label('Produk')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', (int) $state))
                    ->sortable(),

                TextColumn::make('comment')
                    ->label('Komentar')
                    ->limit(50)
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
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
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}