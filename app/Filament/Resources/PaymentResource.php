<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Payment;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Manajemen';

    protected static ?string $modelLabel = 'Pembayaran';

    protected static ?string $pluralModelLabel = 'Monitoring Transaksi';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order.order_number')
                    ->label('Order')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('method')
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'cod' => 'COD',
                        'bank_transfer' => 'Transfer Bank',
                        default => $state ?? '-',
                    }),
                Tables\Columns\TextColumn::make('bankAccount.name')
                    ->label('Bank')
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('bankAccount.account_number')
                    ->label('No. Rekening')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => Payment::statusOptions()[$state] ?? $state)
                    ->color(fn (string $state): string => match ($state) {
                        Payment::STATUS_CONFIRMED => 'success',
                        Payment::STATUS_FAILED => 'danger',
                        Payment::STATUS_AWAITING_CONFIRMATION => 'warning',
                        Payment::STATUS_PENDING => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('paid_at')
                    ->dateTime()
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(Payment::statusOptions()),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('confirm')
                    ->label('Terkonfirmasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn (Payment $record) => $record->confirmFromAdmin())
                    ->visible(fn (Payment $record) => $record->status === Payment::STATUS_AWAITING_CONFIRMATION),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'view' => Pages\ViewPayment::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
