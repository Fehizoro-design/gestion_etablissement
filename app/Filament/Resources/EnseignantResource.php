<?php

namespace App\Filament\Resources;

use App\Enums\Sexe;
use App\Filament\Resources\EnseignantResource\Pages;
use App\Models\Enseignant;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Schemas;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class EnseignantResource extends Resource
{
    protected static ?string $model = Enseignant::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';

    protected static string|\UnitEnum|null $navigationGroup = 'Gestion Scolaire';

    protected static ?string $navigationLabel = 'Enseignants';

    protected static ?string $modelLabel = 'Enseignant';

    protected static ?string $pluralModelLabel = 'Enseignants';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                \Filament\Schemas\Components\Section::make('Informations personnelles')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('nom')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('prenom')
                            ->label('Prénom')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('sexe')
                            ->options(Sexe::class)
                            ->required(),
                        Forms\Components\DatePicker::make('date_naissance')
                            ->label('Date de naissance'),
                        Forms\Components\TextInput::make('lieu_naissance')
                            ->label('Lieu de naissance')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nationalite')
                            ->label('Nationalité')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('numero_cin')
                            ->label('Numéro CIN')
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('photo')
                            ->image()
                            ->avatar()
                            ->directory('enseignants')
                            ->columnSpanFull(),
                    ]),
                \Filament\Schemas\Components\Section::make('Contact')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('telephone')
                            ->label('Téléphone')
                            ->tel()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('adresse')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),
                \Filament\Schemas\Components\Section::make('Informations professionnelles')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('diplome')
                            ->label('Diplôme')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('specialite')
                            ->label('Spécialité')
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('date_embauche')
                            ->label('Date d\'embauche'),
                        Forms\Components\TextInput::make('salaire_base')
                            ->label('Salaire de base')
                            ->numeric()
                            ->prefix('Ar')
                            ->default(0),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Actif')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->circular()
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?background=6366f1&color=fff&name=U'),
                Tables\Columns\TextColumn::make('nom')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('prenom')
                    ->label('Prénom')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('telephone')
                    ->label('Téléphone'),
                Tables\Columns\TextColumn::make('specialite')
                    ->label('Spécialité'),
                Tables\Columns\TextColumn::make('salaire_base')
                    ->label('Salaire')
                    ->money('MGA')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Actif')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Statut')
                    ->trueLabel('Actifs')
                    ->falseLabel('Inactifs'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEnseignants::route('/'),
            'create' => Pages\CreateEnseignant::route('/create'),
            'edit' => Pages\EditEnseignant::route('/{record}/edit'),
        ];
    }
}
