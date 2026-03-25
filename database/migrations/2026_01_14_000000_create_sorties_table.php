<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sorties', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 200);
            $table->enum('type', ['journee','sejour_specifique']);
            $table->string('lieu', 200)->nullable();
            $table->dateTime('date_depart')->index('idx_sorties_date');
            $table->dateTime('date_retour')->nullable();
            $table->foreignId('responsable_id')->nullable()->constrained('membres')->nullOnDelete();
            $table->enum('statut', ['ouvert','inscriptions_closes','depart_confirme','termine','annule'])->default('ouvert')->index('idx_sorties_statut');
            $table->smallInteger('nb_mineurs')->default(0);
            $table->boolean('ddcs_declaration_effectuee')->default(false); // L-03
            $table->date('ddcs_declaration_le')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['nb_mineurs', 'type'], 'idx_sorties_mineurs');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sorties');
    }
};
