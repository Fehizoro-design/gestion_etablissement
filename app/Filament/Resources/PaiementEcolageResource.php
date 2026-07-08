<?php

namespace App\Filament\Resources;

use App\Enums\ModePaiement;
use App\Enums\StatutPaiement;
use App\Filament\Resources\PaiementEcolageResource\Pages;
use App\Models\PaiementEcolage;
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

class PaiementEcolageResource extends Resource
{
    protected static ?string $model = PaiementEcolage::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-currency-dollar';

    protected static string|\UnitEnum|null $navigationGroup = 'Finances';

    protected static ?string $navigationLabel = 'Écolages';

    protected static ?string $modelLabel = 'Paiement écolage';

    protected static ?string $pluralModelLabel = 'Paiements écolages';

    protected static ?int $navigationSort = 2;

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
                Forms\Components\Select::make('eleve_id')
                    ->label('Élève')
                    ->relationship('eleve', 'nom')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->matricule.' - '.$record->prenom.' '.$record->nom)
                    ->searchable(['nom', 'prenom', 'matricule'])
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('annee_scolaire_id')
                    ->label('Année scolaire')
                    ->relationship('anneeScolaire', 'libelle')
                    ->required()
                    ->preload(),
                Forms\Components\Select::make('mois_concerne')
                    ->label('Mois concerné')
                    ->options([
                        1 => 'Janvier', 2 => 'Février', 3 => 'Mars',
                        4 => 'Avril', 5 => 'Mai', 6 => 'Juin',
                        7 => 'Juillet', 8 => 'Août', 9 => 'Septembre',
                        10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('montant')
                    ->numeric()
                    ->prefix('Ar')
                    ->required(),
                Forms\Components\TextInput::make('montant_restant')
                    ->label('Montant restant')
                    ->numeric()
                    ->prefix('Ar')
                    ->default(0),
                Forms\Components\Select::make('statut')
                    ->options(StatutPaiement::class)
                    ->required()
                    ->default(StatutPaiement::Paye),
                Forms\Components\Select::make('mode_paiement')
                    ->label('Mode de paiement')
                    ->options(ModePaiement::class),
                Forms\Components\DatePicker::make('date_paiement')
                    ->label('Date de paiement')
                    ->required()
                    ->default(now()),
                Forms\Components\TextInput::make('reference')
                    ->label('Référence')
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
                Tables\Columns\TextColumn::make('eleve.nom')
                    ->label('Élève')
                    ->formatStateUsing(fn ($record) => $record->eleve->matricule.' - '.$record->eleve->prenom.' '.$record->eleve->nom)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('anneeScolaire.libelle')
                    ->label('Année'),
                Tables\Columns\TextColumn::make('mois_concerne')
                    ->label('Mois')
                    ->formatStateUsing(fn ($record) => $record->moisLibelle()),
                Tables\Columns\TextColumn::make('montant')
                    ->money('MGA')
                    ->sortable(),
                Tables\Columns\TextColumn::make('montant_restant')
                    ->label('Restant')
                    ->money('MGA'),
                Tables\Columns\TextColumn::make('statut')
                    ->badge()
                    ->color(fn (StatutPaiement $state) => match ($state) {
                        StatutPaiement::Paye => 'success',
                        StatutPaiement::Partiel => 'warning',
                        StatutPaiement::EnAttente => 'danger',
                    }),
                Tables\Columns\TextColumn::make('date_paiement')
                    ->label('Date')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->defaultSort('date_paiement', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('statut')
                    ->options(StatutPaiement::class),
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
            'index' => Pages\ListPaiementEcolages::route('/'),
            'create' => Pages\CreatePaiementEcolage::route('/create'),
            'edit' => Pages\EditPaiementEcolage::route('/{record}/edit'),
        ];
    }
}
