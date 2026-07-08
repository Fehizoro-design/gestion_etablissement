<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnneeScolaireResource\Pages;
use App\Models\AnneeScolaire;
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

class AnneeScolaireResource extends Resource
{
    protected static ?string $model = AnneeScolaire::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static string|\UnitEnum|null $navigationGroup = 'Configuration';

    protected static ?string $navigationLabel = 'Années scolaires';

    protected static ?string $modelLabel = 'Année scolaire';

    protected static ?string $pluralModelLabel = 'Années scolaires';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                \Filament\Schemas\Components\Section::make('Année scolaire')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('libelle')
                            ->label('Libellé')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Ex: 2025-2026'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Année active')
                            ->default(false),
                        Forms\Components\DatePicker::make('date_debut')
                            ->label('Date de début')
                            ->required(),
                        Forms\Components\DatePicker::make('date_fin')
                            ->label('Date de fin')
                            ->required()
                            ->after('date_debut'),
                    ]),
                \Filament\Schemas\Components\Section::make('Périodes')
                    ->schema([
                        Forms\Components\Repeater::make('periodes')
                            ->relationship()
                            ->schema([
                                Forms\Components\TextInput::make('libelle')
                                    ->label('Libellé')
                                    ->required()
                                    ->placeholder('Ex: Trimestre 1'),
                                Forms\Components\DatePicker::make('date_debut')
                                    ->label('Début')
                                    ->required(),
                                Forms\Components\DatePicker::make('date_fin')
                                    ->label('Fin')
                                    ->required(),
                                Forms\Components\TextInput::make('ordre')
                                    ->label('Ordre')
                                    ->numeric()
                                    ->default(1)
                                    ->required(),
                            ])
                            ->columns(4)
                            ->defaultItems(3)
                            ->addActionLabel('Ajouter une période')
                            ->reorderable()
                            ->collapsible(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('libelle')
                    ->label('Année scolaire')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_debut')
                    ->label('Début')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_fin')
                    ->label('Fin')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('periodes_count')
                    ->label('Périodes')
                    ->counts('periodes'),
            ])
            ->defaultSort('date_debut', 'desc')
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
            'index' => Pages\ListAnneeScolaires::route('/'),
            'create' => Pages\CreateAnneeScolaire::route('/create'),
            'edit' => Pages\EditAnneeScolaire::route('/{record}/edit'),
        ];
    }
}
