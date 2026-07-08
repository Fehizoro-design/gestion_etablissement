<?php

namespace App\Filament\Resources;

use App\Enums\TypeNote;
use App\Filament\Resources\NoteResource\Pages;
use App\Models\Note;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Schemas;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class NoteResource extends Resource
{
    protected static ?string $model = Note::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static string|\UnitEnum|null $navigationGroup = 'Gestion Scolaire';

    protected static ?string $navigationLabel = 'Notes';

    protected static ?string $modelLabel = 'Note';

    protected static ?string $pluralModelLabel = 'Notes';

    protected static ?int $navigationSort = 4;

    protected static bool $isScopedToTenant = false;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('eleve', function ($query) {
            $query->where('etablissement_id', Filament::getTenant()?->id);
        });
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                \Filament\Schemas\Components\Section::make('Évaluation')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('eleve_id')
                            ->label('Élève')
                            ->relationship('eleve', 'nom')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->prenom.' '.$record->nom)
                            ->searchable(['nom', 'prenom'])
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('classe_id')
                            ->label('Classe')
                            ->relationship('classe', 'nom')
                            ->required()
                            ->preload(),
                        Forms\Components\Select::make('matiere_id')
                            ->label('Matière')
                            ->relationship('matiere', 'nom')
                            ->required()
                            ->preload(),
                        Forms\Components\Select::make('periode_id')
                            ->label('Période')
                            ->relationship('periode', 'libelle')
                            ->required()
                            ->preload(),
                        Forms\Components\Select::make('type')
                            ->label('Type d\'évaluation')
                            ->options(TypeNote::class)
                            ->required(),
                        Forms\Components\DatePicker::make('date_evaluation')
                            ->label('Date de l\'évaluation')
                            ->required()
                            ->default(now()),
                    ]),
                \Filament\Schemas\Components\Section::make('Notation')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('note')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->step(0.25),
                        Forms\Components\TextInput::make('note_sur')
                            ->label('Note sur')
                            ->numeric()
                            ->required()
                            ->default(20)
                            ->minValue(1),
                        Forms\Components\TextInput::make('commentaire')
                            ->label('Commentaire')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('eleve.nom')
                    ->label('Élève')
                    ->formatStateUsing(fn ($record) => $record->eleve->prenom.' '.$record->eleve->nom)
                    ->searchable(['nom', 'prenom'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('classe.nom')
                    ->label('Classe')
                    ->sortable(),
                Tables\Columns\TextColumn::make('matiere.nom')
                    ->label('Matière')
                    ->sortable(),
                Tables\Columns\TextColumn::make('periode.libelle')
                    ->label('Période')
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge(),
                Tables\Columns\TextColumn::make('note')
                    ->formatStateUsing(fn ($record) => $record->note.'/'.$record->note_sur)
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_evaluation')
                    ->label('Date')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->defaultSort('date_evaluation', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('classe_id')
                    ->label('Classe')
                    ->relationship('classe', 'nom'),
                Tables\Filters\SelectFilter::make('matiere_id')
                    ->label('Matière')
                    ->relationship('matiere', 'nom'),
                Tables\Filters\SelectFilter::make('periode_id')
                    ->label('Période')
                    ->relationship('periode', 'libelle'),
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
            'index' => Pages\ListNotes::route('/'),
            'create' => Pages\CreateNote::route('/create'),
            'edit' => Pages\EditNote::route('/{record}/edit'),
        ];
    }
}
