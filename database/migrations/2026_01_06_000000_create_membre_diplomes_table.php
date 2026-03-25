<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membre_diplomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membre_id')->constrained('membres')->cascadeOnDelete();
            $table->foreignId('diplome_referentiel_id')->constrained('diplomes_referentiel')->restrictOnDelete();
            $table->date('date_obtention');
            $table->date('date_expiration')->nullable()->index('idx_diplomes_expiration');
            $table->date('date_dernier_recyclage')->nullable();
            $table->enum('statut', ['valide','a_recycler','abroge','invalide'])->default('valide');
            $table->string('justificatif_path', 255);
            $table->string('carte_pro_path', 255)->nullable();
            $table->foreignId('valide_par_id')->nullable()->constrained('membres')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['membre_id', 'statut'], 'idx_diplomes_statut');
            $table->index('membre_id', 'idx_diplomes_membre');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membre_diplomes');
    }
};
