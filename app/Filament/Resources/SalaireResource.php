<?php

namespace App\Filament\Resources;

use App\Enums\ModePaiement;
use App\Enums\StatutSalaire;
use App\Filament\Resources\SalaireResource\Pages;
use App\Models\Salaire;
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

class SalaireResource extends Resource
{
    protected static ?string $model = Salaire::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected static string|\UnitEnum|null $navigationGroup = 'Finances';

    protected static ?string $navigationLabel = 'Salaires';

    protected static ?string $modelLabel = 'Salaire';

    protected static ?string $pluralModelLabel = 'Salaires';

    protected static ?int $navigationSort = 1;

    protected static bool $isScopedToTenant = false;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('enseignant', function ($query) {
            $query->where('etablissement_id', Filament::getTenant()?->id);
        });
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('enseignant_id')
                    ->label('Enseignant')
                    ->relationship('enseignant', 'nom')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->prenom.' '.$record->nom)
                    ->searchable(['nom', 'prenom'])
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('montant')
                    ->numeric()
                    ->prefix('Ar')
                    ->required(),
                Forms\Components\Select::make('mois')
                    ->options([
                        1 => 'Janvier', 2 => 'Février', 3 => 'Mars',
                        4 => 'Avril', 5 => 'Mai', 6 => 'Juin',
                        7 => 'Juillet', 8 => 'Août', 9 => 'Septembre',
                        10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('annee')
                    ->label('Année')
                    ->numeric()
                    ->required()
                    ->default(now()->year),
                Forms\Components\Select::make('statut')
                    ->options(StatutSalaire::class)
                    ->required()
                    ->default(StatutSalaire::EnAttente),
                Forms\Components\Select::make('mode_paiement')
                    ->label('Mode de paiement')
                    ->options(ModePaiement::class),
                Forms\Components\DatePicker::make('date_paiement')
                    ->label('Date de paiement'),
                Forms\Components\TextInput::make('reference')
                    ->label('Référence transaction')
                    ->maxLength(255),
                Forms\Components\Textarea::make('remarques')
                    ->rows(2)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('enseignant.nom')
                    ->label('Enseignant')
                    ->formatStateUsing(fn ($record) => $record->enseignant->prenom.' '.$record->enseignant->nom)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('montant')
                    ->money('MGA')
                    ->sortable(),
                Tables\Columns\TextColumn::make('mois')
                    ->formatStateUsing(fn ($record) => $record->moisLibelle())
                    ->sortable(),
                Tables\Columns\TextColumn::make('annee')
                    ->label('Année')
                    ->sortable(),
                Tables\Columns\TextColumn::make('statut')
                    ->badge()
                    ->color(fn (StatutSalaire $state) => match ($state) {
                        StatutSalaire::Paye => 'success',
                        StatutSalaire::EnAttente => 'warning',
                        StatutSalaire::Annule => 'danger',
                    }),
                Tables\Columns\TextColumn::make('date_paiement')
                    ->label('Date paiement')
                    ->date('d/m/Y'),
            ])
            ->defaultSort('annee', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('statut')
                    ->options(StatutSalaire::class),
                Tables\Filters\SelectFilter::make('mois')
                    ->options([
                        1 => 'Janvier', 2 => 'Février', 3 => 'Mars',
                        4 => 'Avril', 5 => 'Mai', 6 => 'Juin',
                        7 => 'Juillet', 8 => 'Août', 9 => 'Septembre',
                        10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre',
                    ]),
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
            'index' => Pages\ListSalaires::route('/'),
            'create' => Pages\CreateSalaire::route('/create'),
            'edit' => Pages\EditSalaire::route('/{record}/edit'),
        ];
    }
}
