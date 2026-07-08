<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MatiereResource\Pages;
use App\Models\Matiere;
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

class MatiereResource extends Resource
{
    protected static ?string $model = Matiere::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-book-open';

    protected static string|\UnitEnum|null $navigationGroup = 'Configuration';

    protected static ?string $navigationLabel = 'Matières';

    protected static ?string $modelLabel = 'Matière';

    protected static ?string $pluralModelLabel = 'Matières';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('nom')
                    ->label('Nom de la matière')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Ex: Mathématiques'),
                Forms\Components\TextInput::make('code')
                    ->label('Code')
                    ->maxLength(20)
                    ->placeholder('Ex: MATH'),
                Forms\Components\TextInput::make('coefficient')
                    ->numeric()
                    ->default(1)
                    ->required()
                    ->step(0.5),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nom')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->sortable(),
                Tables\Columns\TextColumn::make('coefficient')
                    ->sortable(),
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
            'index' => Pages\ListMatieres::route('/'),
            'create' => Pages\CreateMatiere::route('/create'),
            'edit' => Pages\EditMatiere::route('/{record}/edit'),
        ];
    }
}
