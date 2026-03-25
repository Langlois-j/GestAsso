<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParametresClubSeeder extends Seeder
{
    public function run(): void
    {
        // 1 seule ligne — id=1 toujours en V1
        DB::table('parametres_club')->updateOrInsert(
            ['id' => 1],
            [
                'nom_club'              => env('CLUB_NOM', 'Mon Association'),
                'numero_affiliation'    => null,
                'date_reaffiliation'    => null,
                'api_url'               => 'https://api.core.myffme.fr/',
                'api_key'               => null,
                'api_statut'            => 'inconnu',
                'api_derniere_synchro'  => null,
                'smtp_host'             => env('MAIL_HOST', null),
                'smtp_port'             => env('MAIL_PORT', null),
                'smtp_user'             => env('MAIL_USERNAME', null),
                'smtp_password'         => null,
                'email_president'       => null,
                'created_at'            => now(),
                'updated_at'            => now(),
            ]
        );
    }
}
