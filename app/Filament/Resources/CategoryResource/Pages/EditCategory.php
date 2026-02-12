<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->before(function ($record) {
                    if ($record->products()->count() > 0) {
                        throw new \Exception("Kategori \"{$record->name}\" masih memiliki produk. Pindahkan produk ke kategori lain terlebih dahulu.");
                    }
                }),
        ];
    }
}
