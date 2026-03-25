<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiplomesReferentielSeeder extends Seeder
{
    public function run(): void
    {
        $diplomes = [
            [
                'code'                       => 'INITIATEUR_SAE',
                'libelle'                    => 'Initiateur SAE',
                'perimetre'                  => 'sae',
                'statut'                     => 'valide',
                'periodicite_recyclage_mois' => 48,
                'organisme_validateur'       => 'CT FFME',
            ],
            [
                'code'                       => 'INITIATEUR_SNE',
                'libelle'                    => 'Initiateur SNE',
                'perimetre'                  => 'sne',
                'statut'                     => 'valide',
                'periodicite_recyclage_mois' => 48,
                'organisme_validateur'       => 'CT FFME',
            ],
            [
                'code'                       => 'MONITEUR_ESCALADE',
                'libelle'                    => 'Moniteur Escalade (ME)',
                'perimetre'                  => 'sae,sne,longueurs',
                'statut'                     => 'valide',
                'periodicite_recyclage_mois' => null,
                'organisme_validateur'       => 'CT FFME',
            ],
            [
                'code'                       => 'BREVET_ETAT',
                'libelle'                    => "Brevet d'État Alpinisme",
                'perimetre'                  => 'sae,sne,longueurs,acm',
                'statut'                     => 'valide',
                'periodicite_recyclage_mois' => null,
                'organisme_validateur'       => 'DDCS / DRAJES',
            ],
            [
                'code'                       => 'DEJEPS_ESCALADE',
                'libelle'                    => 'DEJEPS Escalade',
                'perimetre'                  => 'sae,sne,longueurs,acm',
                'statut'                     => 'valide',
                'periodicite_recyclage_mois' => null,
                'organisme_validateur'       => 'DRAJES',
            ],
            [
                'code'                       => 'BPJEPS_ESCALADE',
                'libelle'                    => 'BPJEPS Escalade',
                'perimetre'                  => 'sae,sne,longueurs',
                'statut'                     => 'valide',
                'periodicite_recyclage_mois' => null,
                'organisme_validateur'       => 'DRAJES',
            ],
            [
                'code'                       => 'PSC1',
                'libelle'                    => 'Prévention et Secours Civiques niveau 1 (PSC1)',
                'perimetre'                  => 'sae,sne,longueurs,acm',
                'statut'                     => 'valide',
                'periodicite_recyclage_mois' => 24,
                'organisme_validateur'       => 'Croix-Rouge / Pompiers / SAMU',
            ],
            [
                'code'                       => 'SST',
                'libelle'                    => 'Sauveteur Secouriste du Travail (SST)',
                'perimetre'                  => 'sae,sne,longueurs,acm',
                'statut'                     => 'valide',
                'periodicite_recyclage_mois' => 24,
                'organisme_validateur'       => 'INRS / organismes habilités',
            ],
            [
                'code'                       => 'ANCIEN_BREVET_FEDERAL',
                'libelle'                    => 'Ancien Brevet Fédéral (abrogé — prérogatives conservées)',
                'perimetre'                  => 'sae,sne',
                'statut'                     => 'abroge',
                'periodicite_recyclage_mois' => null,
                'organisme_validateur'       => null,
            ],
        ];

        foreach ($diplomes as $diplome) {
            DB::table('diplomes_referentiel')->updateOrInsert(
                ['code' => $diplome['code']],
                array_merge($diplome, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
