<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClasseResource\Pages;
use App\Models\Classe;
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

class ClasseResource extends Resource
{
    protected static ?string $model = Classe::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-group';

    protected static string|\UnitEnum|null $navigationGroup = 'Gestion Scolaire';

    protected static ?string $navigationLabel = 'Classes';

    protected static ?string $modelLabel = 'Classe';

    protected static ?string $pluralModelLabel = 'Classes';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('nom')
                    ->label('Nom de la classe')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Ex: 6ème A, TS2'),
                Forms\Components\Select::make('niveau_id')
                    ->label('Niveau')
                    ->relationship('niveau', 'libelle')
                    ->required()
                    ->preload(),
                Forms\Components\Select::make('annee_scolaire_id')
                    ->label('Année scolaire')
                    ->relationship('anneeScolaire', 'libelle')
                    ->required()
                    ->preload(),
                Forms\Components\TextInput::make('capacite_max')
                    ->label('Capacité maximale')
                    ->numeric()
                    ->placeholder('Ex: 40'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nom')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('niveau.libelle')
                    ->label('Niveau')
                    ->sortable(),
                Tables\Columns\TextColumn::make('anneeScolaire.libelle')
                    ->label('Année scolaire')
                    ->sortable(),
                Tables\Columns\TextColumn::make('capacite_max')
                    ->label('Capacité max'),
                Tables\Columns\TextColumn::make('eleves_count')
                    ->label('Effectif')
                    ->counts('eleves'),
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
            'index' => Pages\ListClasses::route('/'),
            'create' => Pages\CreateClasse::route('/create'),
            'edit' => Pages\EditClasse::route('/{record}/edit'),
        ];
    }
}
