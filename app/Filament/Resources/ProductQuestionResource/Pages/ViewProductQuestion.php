<?php

namespace App\Filament\Resources\ProductQuestionResource\Pages;

use App\Filament\Resources\ProductQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProductQuestion extends ViewRecord
{
    protected static string $resource = ProductQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
