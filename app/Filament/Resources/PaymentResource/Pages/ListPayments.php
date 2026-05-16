<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Pages\ManageQrisSettings;
use App\Filament\Resources\PaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPayments extends ListRecords
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('manageQris')
                ->label('Atur QRIS')
                ->icon('heroicon-o-qr-code')
                ->url(ManageQrisSettings::getUrl()),
        ];
    }
}
