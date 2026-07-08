<?php

namespace App\Filament\Pages;

use App\Enums\RoleEtablissement;
use App\Enums\TypeEtablissement;
use App\Models\Etablissement;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Schema;

class CreateEtablissement extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Créer un établissement';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('nom')
                    ->label('Nom de l\'établissement')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Ex: Lycée Jean Moulin'),
                Select::make('type')
                    ->label('Type d\'établissement')
                    ->options(TypeEtablissement::class)
                    ->required(),
                TextInput::make('adresse')
                    ->label('Adresse')
                    ->maxLength(255),
                TextInput::make('ville')
                    ->label('Ville')
                    ->maxLength(255),
                TextInput::make('pays')
                    ->label('Pays')
                    ->maxLength(255)
                    ->default('Madagascar'),
                TextInput::make('telephone')
                    ->label('Téléphone')
                    ->tel()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email de l\'établissement')
                    ->email()
                    ->maxLength(255),
                Textarea::make('description')
                    ->label('Description')
                    ->rows(3)
                    ->maxLength(1000),
                TextInput::make('devise')
                    ->label('Devise / Slogan')
                    ->maxLength(255)
                    ->placeholder('Ex: L\'excellence pour tous'),
            ]);
    }

    protected function handleRegistration(array $data): Etablissement
    {
        $etablissement = Etablissement::create([
            ...$data,
            'user_id' => auth()->id(),
        ]);

        $etablissement->members()->attach(auth()->id(), [
            'role' => RoleEtablissement::Proprietaire->value,
        ]);

        return $etablissement;
    }
}
