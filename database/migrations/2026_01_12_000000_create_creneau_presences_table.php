<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('creneau_presences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creneau_id')->constrained('creneaux')->cascadeOnDelete();
            $table->foreignId('membre_id')->constrained('membres')->cascadeOnDelete();
            $table->boolean('present')->default(false);
            $table->enum('autonomie_icone', ['rouge','jaune','orange','vert','bleu','violet'])->nullable(); // L-01
            $table->enum('autonomie_source', ['api_ffme','manuel_encadrant','manuel_membre'])->nullable();
            $table->foreignId('autonomie_saisie_par_id')->nullable()->constrained('membres')->nullOnDelete();
            $table->timestamps();

            $table->unique(['creneau_id', 'membre_id']);
            $table->index('creneau_id', 'idx_presences_creneau');
            $table->index('membre_id', 'idx_presences_membre');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('creneau_presences');
    }
};
