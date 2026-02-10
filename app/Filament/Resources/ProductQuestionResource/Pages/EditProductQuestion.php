<?php

namespace App\Filament\Resources\ProductQuestionResource\Pages;

use App\Filament\Resources\ProductQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductQuestion extends EditRecord
{
    protected static string $resource = ProductQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (! empty($data['answer'])) {
            $data['answered_by'] = auth()->id();
            $data['answered_at'] = now();
        }
        return $data;
    }
}
