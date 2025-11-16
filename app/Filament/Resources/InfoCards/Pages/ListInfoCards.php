<?php

namespace App\Filament\Resources\InfoCards\Pages;

use App\Filament\Resources\InfoCards\InfoCardResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInfoCards extends ListRecords
{
    protected static string $resource = InfoCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
