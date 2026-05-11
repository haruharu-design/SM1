<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Manajemen';

    protected static ?string $modelLabel = 'Order';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('status')
                    ->options(Order::statusOptions())
                    ->required(),
                Forms\Components\TextInput::make('tracking_number')
                    ->label('Nomor Resi / No. Kurir')
                    ->maxLength(255),
                Forms\Components\Textarea::make('shipping_address')
                    ->columnSpanFull()
                    ->readOnly(),
                Forms\Components\TextInput::make('shipping_phone')
                    ->tel()
                    ->readOnly(),
                Forms\Components\TextInput::make('distance_km')
                    ->label('Jarak (km)')
                    ->numeric()
                    ->suffix('km')
                    ->readOnly()
                    ->dehydrated(false),
                Forms\Components\TextInput::make('shipping_cost')
                    ->label('Biaya Pengiriman')
                    ->numeric()
                    ->prefix('Rp')
                    ->readOnly()
                    ->dehydrated(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount')
                    ->label('Voucher (Rp)')
                    ->money('IDR')
                    ->placeholder('—')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('coupon_code')
                    ->label('Kode voucher')
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('total')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('distance_km')
                    ->label('Jarak (km)')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('shipping_cost')
                    ->label('Ongkir')
                    ->money('IDR')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => Order::statusOptions()[$state] ?? $state)
                    ->color(fn (string $state): string => match ($state) {
                        Order::STATUS_COMPLETED => 'success',
                        Order::STATUS_SHIPPED => 'info',
                        Order::STATUS_PROCESSING => 'warning',
                        Order::STATUS_CANCELLED => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(Order::statusOptions()),
            ])
            ->actions([
                Tables\Actions\Action::make('confirmPayment')
                    ->label('Konfirmasi bayar')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi pembayaran transfer?')
                    ->modalDescription('Sama seperti tombol di halaman pembayaran: status pembayaran jadi terkonfirmasi dan pesanan diproses.')
                    ->visible(fn (Order $record): bool => $record->awaitsAdminBankTransferConfirmation())
                    ->action(function (Order $record): void {
                        $payment = $record->getAwaitingBankTransferPayment();
                        if (! $payment) {
                            Notification::make()->title('Gagal')->body('Tidak ada pembayaran yang menunggu konfirmasi.')->danger()->send();

                            return;
                        }

                        try {
                            $payment->confirmFromAdmin();
                            Notification::make()->title('Pembayaran dikonfirmasi')->success()->send();
                        } catch (\Throwable $e) {
                            Notification::make()->title('Gagal')->body($e->getMessage())->danger()->send();
                        }
                    }),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\OrderItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
