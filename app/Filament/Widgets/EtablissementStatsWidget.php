<?php

namespace App\Filament\Widgets;

use App\Enums\StatutPaiement;
use App\Enums\StatutSalaire;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\PaiementEcolage;
use App\Models\Salaire;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EtablissementStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $tenant = Filament::getTenant();

        if (! $tenant) {
            return [];
        }

        $totalEleves = Eleve::where('etablissement_id', $tenant->id)
            ->where('is_active', true)
            ->count();

        $totalEnseignants = Enseignant::where('etablissement_id', $tenant->id)
            ->where('is_active', true)
            ->count();

        $totalClasses = Classe::where('etablissement_id', $tenant->id)->count();

        $ecolagesImpayees = PaiementEcolage::whereHas('eleve', fn ($q) => $q->where('etablissement_id', $tenant->id))
            ->where('statut', StatutPaiement::EnAttente)
            ->count();

        $salairesEnAttente = Salaire::whereHas('enseignant', fn ($q) => $q->where('etablissement_id', $tenant->id))
            ->where('statut', StatutSalaire::EnAttente)
            ->count();

        return [
            Stat::make('Élèves actifs', $totalEleves)
                ->description('Élèves inscrits')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5]),
            Stat::make('Enseignants', $totalEnseignants)
                ->description('Enseignants actifs')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('info')
                ->chart([3, 5, 2, 4, 6, 3, 5]),
            Stat::make('Classes', $totalClasses)
                ->description('Classes ouvertes')
                ->descriptionIcon('heroicon-m-rectangle-group')
                ->color('warning'),
            Stat::make('Écolages impayés', $ecolagesImpayees)
                ->description('Paiements en attente')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($ecolagesImpayees > 0 ? 'danger' : 'success'),
            Stat::make('Salaires en attente', $salairesEnAttente)
                ->description('Salaires à payer')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color($salairesEnAttente > 0 ? 'danger' : 'success'),
        ];
    }
}
