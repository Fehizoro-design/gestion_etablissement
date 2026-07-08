<?php

namespace App\Filament\Resources;

use App\Enums\Sexe;
use App\Filament\Resources\EleveResource\Pages;
use App\Models\Eleve;
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

class EleveResource extends Resource
{
    protected static ?string $model = Eleve::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static string|\UnitEnum|null $navigationGroup = 'Gestion Scolaire';

    protected static ?string $navigationLabel = 'Élèves';

    protected static ?string $modelLabel = 'Élève';

    protected static ?string $pluralModelLabel = 'Élèves';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                \Filament\Schemas\Components\Section::make('Informations de l\'élève')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('matricule')
                            ->label('Matricule')
                            ->disabled()
                            ->dehydrated(false)
                            ->placeholder('Généré automatiquement')
                            ->visibleOn('edit'),
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
                            ->label('Date de naissance')
                            ->required(),
                        Forms\Components\TextInput::make('lieu_naissance')
                            ->label('Lieu de naissance')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nationalite')
                            ->label('Nationalité')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('adresse')
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('photo')
                            ->image()
                            ->avatar()
                            ->directory('eleves')
                            ->columnSpanFull(),
                    ]),
                \Filament\Schemas\Components\Section::make('Informations du parent / tuteur')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('nom_parent')
                            ->label('Nom du parent')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('prenom_parent')
                            ->label('Prénom du parent')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('telephone_parent')
                            ->label('Téléphone du parent')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email_parent')
                            ->label('Email du parent')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('profession_parent')
                            ->label('Profession du parent')
                            ->maxLength(255),
                    ]),
                \Filament\Schemas\Components\Section::make('Informations médicales')
                    ->columns(2)
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('groupe_sanguin')
                            ->label('Groupe sanguin')
                            ->maxLength(10),
                        Forms\Components\Textarea::make('allergies')
                            ->label('Allergies connues')
                            ->rows(2),
                        Forms\Components\Textarea::make('remarques')
                            ->label('Remarques')
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),
                \Filament\Schemas\Components\Section::make('Inscription')
                    ->columns(2)
                    ->schema([
                        Forms\Components\DatePicker::make('date_inscription')
                            ->label('Date d\'inscription')
                            ->required()
                            ->default(now()),
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
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?background=6366f1&color=fff&name=E'),
                Tables\Columns\TextColumn::make('matricule')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nom')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('prenom')
                    ->label('Prénom')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_naissance')
                    ->label('Date de naissance')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('telephone_parent')
                    ->label('Tél. parent'),
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
            'index' => Pages\ListEleves::route('/'),
            'create' => Pages\CreateEleve::route('/create'),
            'edit' => Pages\EditEleve::route('/{record}/edit'),
        ];
    }
}
