<?php


namespace App\Filament\Resources\Orders;

use App\Filament\Resources\Orders\RelationManagers\ItemsRelationManager;
use App\Filament\Resources\Orders\Pages\CreateOrders;
use App\Filament\Resources\Orders\Pages\EditOrders;
use App\Filament\Resources\Orders\Pages\ListOrders;
use App\Filament\Resources\Orders\Schemas\OrdersForm;
use App\Filament\Resources\Orders\Tables\OrdersTable;
use App\Models\Orders;
use App\Models\product_order_track_histories;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OrdersResource extends Resource
{
    protected static ?string $model = Orders::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shopping-cart';

    protected static UnitEnum|string|null $navigationGroup = 'Shop Management';

    protected static ?string $navigationLabel =  'Pesanan';

    protected static ?string $modelLabel = 'Pesanan';

    protected static ?string $pluralModelLabel = 'Pesanan';

    protected static ?int $navigationSort = 4;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['userId'] = Auth::id();

        return $data;
    }

    public static function getEloquentQuery(): Builder
    {
    $query = parent::getEloquentQuery();

    /** @var \App\Models\User $user */
    $user = Auth::user();

    if ($user) {
        if (!$user->hasRole('super_admin')) {
            $query->where('userId', $user->id)
                ->whereIn('orderStatus', ['Sedang DiKemas', 'DiKirim', 'Selesai', 'Dibatalkan']);
        }
    }

    return $query;
    }

    public static function form(Schema $schema): Schema
    {
        return OrdersForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrdersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ItemsRelationManager::class,
        ];
    }
    public static function getPages(): array
    {
        return [
            'index' => ListOrders::route('/'),
            'create' => CreateOrders::route('/create'),
            'edit' => EditOrders::route('/{record}/edit'),
        ];
    }

    private static function addTracking($order, $status, $remarks = null)
    {
        product_order_track_histories::create([
            'orderId' => $order->id,
            'status'  => $status,
            'remarks' => $remarks,
        ]);
    }
}
