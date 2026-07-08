<?php

namespace Database\Seeders;

use App\Enums\RoleEtablissement;
use App\Enums\TypeEtablissement;
use App\Models\AnneeScolaire;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\Etablissement;
use App\Models\Matiere;
use App\Models\Niveau;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user
        $user = User::factory()->create([
            'name' => 'Admin MyStudi',
            'email' => 'admin@mystudi.mg',
        ]);

        // Create establishment
        $etablissement = Etablissement::create([
            'user_id' => $user->id,
            'nom' => 'Lycée MyStudi Antananarivo',
            'type' => TypeEtablissement::Lycee,
            'adresse' => 'Lot IVG 123 Analakely',
            'ville' => 'Antananarivo',
            'pays' => 'Madagascar',
            'telephone' => '+261 34 00 000 00',
            'email' => 'contact@mystudi.mg',
            'devise' => 'L\'excellence pour tous',
        ]);

        // Attach user as owner
        $etablissement->members()->attach($user->id, [
            'role' => RoleEtablissement::Proprietaire->value,
        ]);

        // Create academic year with periods
        $annee = AnneeScolaire::create([
            'etablissement_id' => $etablissement->id,
            'libelle' => '2025-2026',
            'date_debut' => '2025-09-01',
            'date_fin' => '2026-07-31',
            'is_active' => true,
        ]);

        $periodes = [];
        $periodesData = [
            ['Trimestre 1', '2025-09-01', '2025-12-15', 1],
            ['Trimestre 2', '2026-01-05', '2026-03-31', 2],
            ['Trimestre 3', '2026-04-14', '2026-07-15', 3],
        ];
        foreach ($periodesData as $p) {
            $periodes[] = Periode::create([
                'annee_scolaire_id' => $annee->id,
                'libelle' => $p[0],
                'date_debut' => $p[1],
                'date_fin' => $p[2],
                'ordre' => $p[3],
            ]);
        }

        // Create levels
        $niveauxData = [
            ['6ème', 1, 100000, 50000],
            ['5ème', 2, 100000, 50000],
            ['4ème', 3, 120000, 60000],
            ['3ème', 4, 120000, 60000],
            ['2nde', 5, 150000, 75000],
            ['1ère', 6, 150000, 75000],
            ['Terminale', 7, 180000, 90000],
        ];
        $niveaux = [];
        foreach ($niveauxData as $n) {
            $niveaux[] = Niveau::create([
                'etablissement_id' => $etablissement->id,
                'libelle' => $n[0],
                'ordre' => $n[1],
                'frais_inscription' => $n[2],
                'frais_ecolage_mensuel' => $n[3],
            ]);
        }

        // Create subjects
        $matieresData = [
            ['Mathématiques', 'MATH', 4],
            ['Français', 'FR', 4],
            ['Malagasy', 'MLG', 2],
            ['Anglais', 'ANG', 2],
            ['Physique-Chimie', 'PC', 3],
            ['SVT', 'SVT', 2],
            ['Histoire-Géographie', 'HG', 2],
            ['EPS', 'EPS', 1],
        ];
        $matieres = [];
        foreach ($matieresData as $m) {
            $matieres[] = Matiere::create([
                'etablissement_id' => $etablissement->id,
                'nom' => $m[0],
                'code' => $m[1],
                'coefficient' => $m[2],
            ]);
        }

        // Create classes for first 3 levels
        foreach (array_slice($niveaux, 0, 3) as $niveau) {
            foreach (['A', 'B'] as $section) {
                Classe::create([
                    'etablissement_id' => $etablissement->id,
                    'niveau_id' => $niveau->id,
                    'annee_scolaire_id' => $annee->id,
                    'nom' => $niveau->libelle.' '.$section,
                    'capacite_max' => 40,
                ]);
            }
        }

        // Create teachers
        Enseignant::factory()
            ->count(10)
            ->for($etablissement)
            ->create();

        // Create students
        Eleve::factory()
            ->count(30)
            ->for($etablissement)
            ->create();
    }
}
