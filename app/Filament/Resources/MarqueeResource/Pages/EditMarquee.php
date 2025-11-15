<?php

namespace App\Filament\Resources\MarqueeResource\Pages;

use App\Filament\Resources\MarqueeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMarquee extends EditRecord
{
    protected static string $resource = MarqueeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
