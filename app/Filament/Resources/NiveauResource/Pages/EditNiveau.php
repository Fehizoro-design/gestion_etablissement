<?php

namespace App\Filament\Resources\NiveauResource\Pages;

use App\Filament\Resources\NiveauResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNiveau extends EditRecord
{
    protected static string $resource = NiveauResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
