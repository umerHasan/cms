<?php

namespace App\Filament\Resources\TopProductSectionResource\Pages;

use App\Filament\Resources\TopProductSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTopProductSections extends ListRecords
{
    protected static string $resource = TopProductSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
