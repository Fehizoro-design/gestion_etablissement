<?php

namespace App\Filament\Resources\PaiementEcolageResource\Pages;

use App\Filament\Resources\PaiementEcolageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaiementEcolage extends EditRecord
{
    protected static string $resource = PaiementEcolageResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
