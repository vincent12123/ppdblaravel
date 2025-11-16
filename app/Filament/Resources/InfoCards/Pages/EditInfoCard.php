<?php

namespace App\Filament\Resources\InfoCards\Pages;

use App\Filament\Resources\InfoCards\InfoCardResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInfoCard extends EditRecord
{
    protected static string $resource = InfoCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
