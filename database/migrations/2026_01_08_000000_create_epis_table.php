<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('epis', function (Blueprint $table) {
            $table->id();
            $table->string('designation', 200);
            $table->string('numero_serie', 100)->unique('idx_epis_serie');
            $table->string('fabricant', 100)->nullable();
            $table->string('modele', 100)->nullable();
            $table->date('date_mise_en_service');
            $table->date('date_fabrication')->nullable();
            $table->enum('statut', ['en_service','hors_service','quarantaine','reforme'])->default('en_service')->index('idx_epis_statut');
            $table->date('date_dernier_controle')->nullable()->index('idx_epis_controle');
            $table->date('prochain_controle_le')->nullable();
            $table->foreignId('gestionnaire_id')->nullable()->constrained('membres')->nullOnDelete()->index('idx_epis_gestionnaire');
            $table->text('commentaire')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('epis');
    }
};
