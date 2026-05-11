<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomeBannerResource\Pages;
use App\Models\HomeBanner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HomeBannerResource extends Resource
{
    protected static ?string $model = HomeBanner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Konten';

    protected static ?string $modelLabel = 'Banner Home';

    protected static ?string $pluralModelLabel = 'Banner Home';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('subtitle')
                ->maxLength(255),
            Forms\Components\TextInput::make('gradient_from')
                ->required()
                ->default('from-red-500')
                ->helperText('Contoh: from-red-500'),
            Forms\Components\TextInput::make('gradient_to')
                ->required()
                ->default('to-red-400')
                ->helperText('Contoh: to-blue-400'),
            Forms\Components\TextInput::make('sort_order')
                ->label('Urutan')
                ->numeric()
                ->default(0)
                ->required(),
            Forms\Components\Toggle::make('is_active')
                ->label('Aktif')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subtitle')
                    ->limit(60),
                Tables\Columns\TextColumn::make('gradient_from')
                    ->badge(),
                Tables\Columns\TextColumn::make('gradient_to')
                    ->badge(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHomeBanners::route('/'),
            'create' => Pages\CreateHomeBanner::route('/create'),
            'edit' => Pages\EditHomeBanner::route('/{record}/edit'),
        ];
    }
}
