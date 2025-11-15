<?php

namespace App\Filament\Resources\MarqueeResource\Pages;

use App\Filament\Resources\MarqueeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMarquees extends ListRecords
{
    protected static string $resource = MarqueeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
