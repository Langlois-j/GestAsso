<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diplomes_referentiel', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('libelle', 200);
            $table->string('perimetre', 100); // sae,sne,longueurs,acm — stocké CSV
            $table->enum('statut', ['valide','abroge'])->default('valide');
            $table->smallInteger('periodicite_recyclage_mois')->nullable();
            $table->string('organisme_validateur', 200)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diplomes_referentiel');
    }
};
