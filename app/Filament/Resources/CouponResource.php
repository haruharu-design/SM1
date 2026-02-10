<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationGroup = 'Manajemen';
    protected static ?string $modelLabel = 'Kupon';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->uppercase(),
                Forms\Components\Select::make('type')
                    ->options(['percentage' => 'Persen', 'fixed' => 'Nominal'])
                    ->required(),
                Forms\Components\TextInput::make('value')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->suffix(fn ($get) => $get('type') === 'percentage' ? '%' : ''),
                Forms\Components\TextInput::make('min_purchase')
                    ->numeric()
                    ->minValue(0)
                    ->prefix('Rp')
                    ->placeholder('Tanpa minimum'),
                Forms\Components\TextInput::make('max_usage')
                    ->numeric()
                    ->minValue(0)
                    ->placeholder('Unlimited'),
                Forms\Components\DateTimePicker::make('valid_from')
                    ->placeholder('Sekarang'),
                Forms\Components\DateTimePicker::make('valid_until')
                    ->placeholder('Selamanya'),
                Forms\Components\Toggle::make('is_active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state === 'percentage' ? 'Persen' : 'Nominal'),
                Tables\Columns\TextColumn::make('value')
                    ->formatStateUsing(fn ($record) => $record->type === 'percentage'
                        ? $record->value . '%'
                        : 'Rp ' . number_format($record->value, 0, ',', '.')),
                Tables\Columns\TextColumn::make('used_count')
                    ->suffix(fn ($record) => $record->max_usage ? " / {$record->max_usage}" : ''),
                Tables\Columns\TextColumn::make('valid_until')
                    ->dateTime()
                    ->placeholder('-'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}
