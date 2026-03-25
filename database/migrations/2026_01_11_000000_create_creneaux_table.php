<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('creneaux', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 200);
            $table->enum('type_support', ['sae','sne','longueurs']);
            $table->string('lieu', 200)->nullable();
            $table->foreignId('responsable_id')->nullable()->constrained('membres')->nullOnDelete()->index('idx_creneaux_responsable');
            $table->foreignId('responsable_defaut_id')->nullable()->constrained('membres')->nullOnDelete();
            $table->enum('statut', ['brouillon','publie','responsable_manquant','annule'])->default('brouillon')->index('idx_creneaux_statut');
            $table->boolean('is_recurrent')->default(false);
            $table->json('recurrence_config')->nullable();
            $table->dateTime('date_debut')->index('idx_creneaux_date');
            $table->dateTime('date_fin');
            $table->smallInteger('capacite_max')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['date_debut', 'date_fin'], 'idx_creneaux_periode');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('creneaux');
    }
};
