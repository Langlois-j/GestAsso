<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('epi_signalements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('epi_id')->constrained('epis')->cascadeOnDelete();
            $table->foreignId('signaleur_id')->constrained('membres')->restrictOnDelete(); // L-02
            $table->text('description');
            $table->timestamp('signale_le')->useCurrent();
            $table->enum('statut', ['ouvert','en_cours','clos'])->default('ouvert');
            $table->foreignId('clos_par_id')->nullable()->constrained('membres')->nullOnDelete();
            $table->timestamp('clos_le')->nullable();
            $table->text('action_corrective')->nullable();
            $table->enum('nouveau_statut_epi', ['en_service','hors_service','quarantaine','reforme'])->nullable();

            $table->index(['epi_id', 'statut'], 'idx_signalements_epi');
            $table->index('signale_le', 'idx_signalements_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('epi_signalements');
    }
};
