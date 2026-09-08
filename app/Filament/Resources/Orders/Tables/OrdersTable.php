<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Models\User;
use Filament\Actions\ActionGroup;
use Filament\Actions\Action as ActionsAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use App\Models\product_order_track_histories;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\Orders\OrdersResource;
use App\Notifications\OrderStatusNotification;
use App\Models\product_reviews;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Components\Section;
use App\Filament\Forms\Components\StarRating;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

               
                TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable()
                    ->hidden(fn() => !Auth::user()?->hasRole('super_admin')),
                TextColumn::make('id_pemesanan')
                    ->label('ID Pemesanan')
                    ->searchable(),
                TextColumn::make('orderDate')
                    ->label('Tanggal Pemesanan')
                    ->date()
                    ->sortable(),
                                TextColumn::make('orderStatus')
                    ->label('Status Pemesanan')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending'   => 'warning',
                        'paid'      => 'success',
                        'processed' => 'info',
                        'shipped'   => 'primary',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default     => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('paymentMethod')
                    ->label('Metode Pembayaran')
                    ->hidden(fn() => !Auth::user()?->hasRole('super_admin'))
                    ->searchable(),
                TextColumn::make('recipient_name')
                    ->label('Penerima')
                    ->hidden(fn() => !Auth::user()?->hasRole('super_admin'))
                    ->searchable(),
                TextColumn::make('phone_number')
                    ->label('Telepon')
                    ->hidden(fn() => !Auth::user()?->hasRole('super_admin'))
                    ->searchable(),
                TextColumn::make('province')
                    ->label('Provinsi')
                    ->hidden(fn() => !Auth::user()?->hasRole('super_admin'))
                    ->searchable(),
                TextColumn::make('city')
                    ->label('Kota')
                    ->hidden(fn() => !Auth::user()?->hasRole('super_admin'))
                    ->searchable(),
                TextColumn::make('street_address')
                    ->label('Alamat Lengkap')
                    ->hidden(fn() => !Auth::user()?->hasRole('super_admin'))
                    ->searchable(),
                TextColumn::make('postal_code')
                    ->label('Kode Pos')
                    ->hidden(fn() => !Auth::user()?->hasRole('super_admin'))
                    ->searchable(),
                TextColumn::make('address_detail')
                    ->label('Detail Alamat')
                    ->hidden(fn() => !Auth::user()?->hasRole('super_admin'))
                    ->searchable(), 
                TextColumn::make('address_label')
                    ->label('Label')
                    ->hidden(fn() => !Auth::user()?->hasRole('super_admin'))
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('total_price')
                    ->label('Total')    
                    ->money('IDR')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actionsColumnLabel('Aksi')
            ->actions([

    ActionGroup::make([
        ActionsAction::make('lihat_detail')
            ->label('Lihat Detail Pesanan')
            ->icon('heroicon-o-eye')
            ->modalHeading(fn ($record) => 'Detail Pesanan #'  . $record->id_pemesanan)
            ->modalContent(fn ($record) => view(
                'filament.modals.order-detail',
                ['order' => $record->load('items.product')]
            ))
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Tutup'),

        ActionsAction::make('tracking')
            ->label('Lacak Pesanan')
            ->icon('heroicon-o-map-pin')
            ->modalHeading(fn ($record) => 'Tracking Pesanan #' . $record->id_pemesanan)
            ->modalContent(fn ($record) => view(
                'filament.modals.order-tracking',
                ['order' => $record->load('tracking')]
            ))
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Tutup'),

        ActionsAction::make('ajukan_return')
            ->label('Ajukan Return & Refund')
            ->icon('heroicon-o-arrow-uturn-left')
            ->visible(fn () => !Auth::user()->hasRole('super_admin'))
            ->modalHeading(fn ($record) => 'Return & Refund - #' . $record->id_pemesanan)
            ->modalContent(function ($record) {
                $user = Auth::user();
                $record->load(['returns.orderItem', 'returns.refund', 'refunds', 'items']);

                $existingReturn = \App\Models\ReturnModel::whereIn('order_item_id', $record->items->pluck('id'))
                    ->where('user_id', $user->id)
                    ->exists();

                if ($existingReturn) {
                    return view('filament.modals.order-return-refund', [
                        'order'   => $record,
                        'isAdmin' => false,
                    ]);
                }

                return null;
            })
            ->form(function ($record) {
                $user = Auth::user();
                $record->load('items');

                $existingReturn = \App\Models\ReturnModel::whereIn('order_item_id', $record->items->pluck('id'))
                    ->where('user_id', $user->id)
                    ->exists();

                if ($existingReturn) return [];

                return [
                    \Filament\Forms\Components\Select::make('order_item_id')
                        ->label('Pilih Produk')
                        ->options($record->items->pluck('product_name', 'id')->toArray())
                        ->required()
                        ->searchable(),

                    \Filament\Forms\Components\Textarea::make('reason')
                        ->label('Alasan Return')
                        ->required()
                        ->rows(3),

                    \Filament\Forms\Components\FileUpload::make('image')
                        ->label('Foto Bukti')
                        ->image()
                        ->directory('returns'),
                ];
            })
            ->action(function ($record, array $data) {
                if (empty($data)) return;

                \App\Models\ReturnModel::create([
                    'order_item_id' => $data['order_item_id'],
                    'user_id'       => Auth::id(),
                    'reason'        => $data['reason'],
                    'image'         => $data['image'] ?? null,
                    'status'        => 'pending',
                ]);

                \Filament\Notifications\Notification::make()
                    ->title('Pengajuan return berhasil dikirim!')
                    ->success()
                    ->send();
            })
            ->modalSubmitActionLabel('Ajukan Return')
            ->modalCancelActionLabel('Tutup'),

        ActionsAction::make('lihat_return')
            ->label('Lihat Return & Refund')
            ->icon('heroicon-o-arrow-uturn-left')
            ->visible(fn () => Auth::user()->hasRole('super_admin'))
            ->modalHeading(fn ($record) => 'Return & Refund - #' . $record->id_pemesanan)
            ->modalContent(fn ($record) => view('filament.modals.order-return-refund', [
                'order'   => $record->load(['returns.orderItem', 'returns.refund', 'refunds']),
                'isAdmin' => true,
            ]))
            ->modalFooterActions(function ($record) {
                $record->load(['returns.orderItem', 'refunds']);
                $actions = [];

                foreach ($record->returns as $return) {
                    if ($return->status === 'pending') {
                        $actions[] = ActionsAction::make('approve_return_' . $return->id)
                            ->label('Setuju')
                            ->color('success')
                            ->action(function () use ($return) {
                                $return->update(['status' => 'approved']);

                                $alreadyRefunded = \App\Models\Refund::where('return_id', $return->id)->exists();
                                if (!$alreadyRefunded) {
                                    \App\Models\Refund::create([
                                        'return_id'   => $return->id,
                                        'order_id'    => $return->orderItem->order_id,
                                        'amount'      => $return->orderItem->price,
                                        'status'      => 'pending',
                                        'refunded_at' => null,
                                    ]);
                                }

                                \Filament\Notifications\Notification::make()
                                    ->title('Return disetujui, refund dibuat!')
                                    ->success()
                                    ->send();
                            });

                        $actions[] = ActionsAction::make('reject_return_' . $return->id)
                            ->label('Tolak')
                            ->color('danger')
                            ->action(function () use ($return) {
                                $return->update(['status' => 'rejected']);

                                \Filament\Notifications\Notification::make()
                                    ->title('Return ditolak.')
                                    ->warning()
                                    ->send();
                            });
                    }
                }

                foreach ($record->refunds as $refund) {
                    if ($refund->status === 'pending') {
                        $actions[] = ActionsAction::make('complete_refund_' . $refund->id)
                            ->label('Selesaikan Refund')
                            ->color('gray')
                            ->extraAttributes([
                                'style' => 'background-color: #9ca3af; color: #030712; border: none;'
                            ])
                            ->action(function () use ($refund) {
                                $refund->update([
                                    'status'      => 'completed',
                                    'refunded_at' => now(),
                                ]);

                                \Filament\Notifications\Notification::make()
                                    ->title('Refund berhasil diselesaikan!')
                                    ->success()
                                    ->send();
                            });
                    }
                }

                return $actions;
            })
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Tutup'),

        ActionsAction::make('reviews')
            ->label('Beri Review Produk')
            ->icon('heroicon-o-star')
            ->visible(function () {
                /** @var User|null $user */
                $user = Auth::user();
                return $user && !$user->hasRole('super_admin');
            })
            ->modalHeading(fn ($record) => 'Review Produk - #' . $record->id_pemesanan)
            ->form(function ($record) {
                $record->load('items.product');

                $productOptions = $record->items
                    ->mapWithKeys(fn ($item) => [
                        $item->product->productCode => $item->product->productName
                    ])
                    ->toArray();

                return [
                    Select::make('productCode')
                        ->label('Pilih Produk')
                        ->options($productOptions)
                        ->required()
                        ->searchable(),

                    StarRating::make('rating')
                        ->label('Rating')
                        ->maxStars(5)
                        ->required(),

                    \Filament\Forms\Components\Textarea::make('comment')
                        ->label('Komentar')
                        ->rows(3)
                        ->maxLength(500)
                        ->nullable(),
                ];
            })
            ->action(function ($record, array $data) {
                product_reviews::updateOrCreate(
                    [
                        'userId'      => $record->userId,
                        'productCode' => $data['productCode'],
                    ],
                    [
                        'rating'  => $data['rating'],
                        'comment' => $data['comment'] ?? null,
                    ]
                );

                \Filament\Notifications\Notification::make()
                    ->title('Review berhasil disimpan!')
                    ->success()
                    ->send();
            })
            ->modalSubmitActionLabel('Simpan Review')
            ->modalCancelActionLabel('Batal'),

        ActionsAction::make('lihat_reviews')
            ->label('Lihat Review Produk')
            ->icon('heroicon-o-eye')
            ->modalHeading(fn ($record) => 'Review Produk - #' . $record->id_pemesanan)
            ->modalContent(function ($record) {
                $record->load('items.product');

                $productCodes = $record->items
                    ->pluck('product.productCode')
                    ->filter()
                    ->toArray();

                $reviews = product_reviews::with('product')
                    ->where('userId', $record->userId)
                    ->whereIn('productCode', $productCodes)
                    ->get();

                return view('filament.modals.order-review-list', [
                    'reviews' => $reviews,
                ]);
            })
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Tutup')
            ->visible(function () {
                /** @var User|null $user */
                $user = Auth::user();
                return $user && $user->hasRole('super_admin');
            }),
    ])
        ->label('Menu')
        ->icon('heroicon-o-ellipsis-vertical')
        ->color('primary')
        ->size('sm'),

    ActionGroup::make([
        ActionsAction::make('Sedang Dikemas')
            ->label('Sedang Dikemas')
            ->icon('heroicon-o-clock')
            ->color('primary')
            ->requiresConfirmation()
            ->action(function ($record) {
                $record->update(['orderStatus' => 'Sedang Dikemas']);

                product_order_track_histories::create([
                    'orderId' => $record->id,
                    'status'  => 'Sedang Dikemas',
                    'remarks' => 'Dikemas Oleh Admin',
                ]);

                $record->user->notify(
                    new OrderStatusNotification($record, 'Sedang Dikemas')
                );
            })
            ->visible(fn () => Auth::user()?->hasRole('super_admin')),

        ActionsAction::make('DiKirim')
            ->label('DiKirim')
            ->icon('heroicon-o-truck')
            ->color('primary')
            ->requiresConfirmation()
            ->action(function ($record) {
                $record->update(['orderStatus' => 'DiKirim']);

                product_order_track_histories::create([
                    'orderId' => $record->id,
                    'status'  => 'DiKirim',
                    'remarks' => 'Pesanan dikirim oleh admin',
                ]);

                $record->user->notify(
                    new OrderStatusNotification($record, 'DiKirim')
                );
            })
            ->visible(fn () => Auth::user()?->hasRole('super_admin')),

        ActionsAction::make('Completed')
            ->label('Completed')
            ->icon('heroicon-o-check')
            ->color('primary')
            ->requiresConfirmation()
            ->action(function ($record) {
                $record->update(['orderStatus' => 'Completed']);

                product_order_track_histories::create([
                    'orderId' => $record->id,
                    'status'  => 'Completed',
                    'remarks' => 'Pesanan selesai',
                ]);

                $record->user->notify(
                    new OrderStatusNotification($record, 'Completed')
                );
            })
            ->visible(fn () => Auth::user()?->hasRole('super_admin')),
         ActionsAction::make('Canceled')
            ->label('Canceled')
            ->icon('heroicon-o-x-circle')
            ->color('primary')
            ->requiresConfirmation()
            ->action(function ($record) {
                $record->update(['orderStatus' => 'Canceled']);

                product_order_track_histories::create([
                    'orderId' => $record->id,
                    'status'  => 'Canceled',
                    'remarks' => 'Pesanan dibatalkan',
                ]);

                $record->user->notify(
                    new OrderStatusNotification($record, 'Canceled')
                );
            })
            ->visible(fn () => Auth::user()?->hasRole('super_admin')),
    ])
        ->label('Status')
        ->icon('heroicon-o-arrow-path')
        ->color('primary')
        ->size('sm'),
        
    EditAction::make()
        ->label('')
        ->icon('heroicon-o-pencil-square'),

    DeleteAction::make()
        ->label('') 
        ->icon('heroicon-o-trash')
        ->color('primary')
        ->size('sm')
        ->tooltip('Delete User')
        ->visible(function () {
            /** @var User|null $user */
            $user = Auth::user();
            return $user && $user->hasRole('super_admin');
        }),

    ActionGroup::make([

    ])
        ->label('Status Akhir')
        ->icon('heroicon-o-flag')
        ->color('primary')
        ->size('sm'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
