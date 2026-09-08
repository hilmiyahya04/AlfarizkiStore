<?php

namespace App\Filament\Resources\ProductVariants;

use App\Filament\Resources\ProductVariants\Pages\CreateProductVariant;
use App\Filament\Resources\ProductVariants\Pages\EditProductVariant;
use App\Filament\Resources\ProductVariants\Pages\ListProductVariants;
use App\Filament\Resources\ProductVariants\Schemas\ProductVariantForm;
use App\Filament\Resources\ProductVariants\Tables\ProductVariantsTable;
use App\Models\ProductVariant;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ProductVariantResource extends Resource
{
    protected static ?string $model = ProductVariant::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static UnitEnum|string|null $navigationGroup = 'Shop Management';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Varian';

    protected static ?string $modelLabel = 'Varian';

    protected static ?string $pluralModelLabel = 'Varian';

    /**
     * Sembunyikan menu 'Varian' dari sidebar jika user bukan super_admin / admin.
     */
    public static function canViewAny(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        // Menu hanya muncul untuk user yang memiliki role 'super_admin' atau 'admin'
        return $user?->hasRole('super_admin') ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return ProductVariantForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductVariantsTable::configure($table);
    }

    /**
     * Filter data varian produk di tabel berdasarkan role.
     */
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (! $user) {
            return $query->whereNull('id');
        }

        // Super Admin dapat melihat semua varian
        if ($user->hasRole('super_admin')) {
            return $query;
        }

        // Jika user biasa diperbolehkan masuk, filter berdasarkan produk/user milik mereka
        // Opsi A: Jika relasi langsung ke user_id
        return $query->where('user_id', $user->id);

        // Opsi B: Jika ProductVariant terhubung ke Product dulu (product.user_id)
        // return $query->whereHas('product', fn ($q) => $q->where('user_id', $user->id));
    }   

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProductVariants::route('/'),
            'create' => CreateProductVariant::route('/create'),
            'edit' => EditProductVariant::route('/{record}/edit'),
        ];
    }
}