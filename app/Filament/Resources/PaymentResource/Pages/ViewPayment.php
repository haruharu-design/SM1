<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Filament\Resources\PaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPayment extends ViewRecord
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('viewOrder')
                ->label('Lihat Order')
                ->url(fn ($record) => OrderResource::getUrl('view', ['record' => $record->order]))
                ->visible(fn ($record) => $record->order_id && $record->order),
        ];
    }
}
