<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NiveauResource\Pages;
use App\Models\Niveau;
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

class NiveauResource extends Resource
{
    protected static ?string $model = Niveau::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-building-library';

    protected static string|\UnitEnum|null $navigationGroup = 'Configuration';

    protected static ?string $navigationLabel = 'Niveaux';

    protected static ?string $modelLabel = 'Niveau';

    protected static ?string $pluralModelLabel = 'Niveaux';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('libelle')
                    ->label('Libellé')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Ex: 6ème, Terminale S'),
                Forms\Components\TextInput::make('ordre')
                    ->label('Ordre d\'affichage')
                    ->numeric()
                    ->default(1)
                    ->required(),
                Forms\Components\TextInput::make('frais_inscription')
                    ->label('Frais d\'inscription')
                    ->numeric()
                    ->prefix('Ar')
                    ->default(0),
                Forms\Components\TextInput::make('frais_ecolage_mensuel')
                    ->label('Écolage mensuel')
                    ->numeric()
                    ->prefix('Ar')
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('libelle')
                    ->label('Libellé')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ordre')
                    ->sortable(),
                Tables\Columns\TextColumn::make('frais_inscription')
                    ->label('Frais inscription')
                    ->money('MGA')
                    ->sortable(),
                Tables\Columns\TextColumn::make('frais_ecolage_mensuel')
                    ->label('Écolage mensuel')
                    ->money('MGA')
                    ->sortable(),
                Tables\Columns\TextColumn::make('classes_count')
                    ->label('Classes')
                    ->counts('classes'),
            ])
            ->defaultSort('ordre')
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
            'index' => Pages\ListNiveaux::route('/'),
            'create' => Pages\CreateNiveau::route('/create'),
            'edit' => Pages\EditNiveau::route('/{record}/edit'),
        ];
    }
}
