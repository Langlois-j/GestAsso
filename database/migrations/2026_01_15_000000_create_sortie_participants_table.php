<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sortie_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sortie_id')->constrained('sorties')->cascadeOnDelete();
            $table->foreignId('membre_id')->constrained('membres')->cascadeOnDelete();
            $table->enum('statut_inscription', ['inscrit','confirme','annule'])->default('inscrit');
            $table->enum('ast_statut', ['non_requis','en_attente','signee','refusee'])->default('non_requis');
            $table->timestamp('ast_signee_le')->nullable();
            $table->foreignId('ast_signataire_id')->nullable()->constrained('responsables_legaux')->nullOnDelete();
            $table->boolean('fiche_sanitaire_fournie')->default(false);
            $table->timestamps();

            $table->unique(['sortie_id', 'membre_id']);
            $table->index('sortie_id', 'idx_participants_sortie');
            $table->index('membre_id', 'idx_participants_membre');
            $table->index(['sortie_id', 'ast_statut'], 'idx_participants_ast');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sortie_participants');
    }
};
