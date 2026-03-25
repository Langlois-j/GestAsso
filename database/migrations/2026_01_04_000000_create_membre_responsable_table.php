<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membre_responsable', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membre_id')->constrained('membres')->cascadeOnDelete();
            $table->foreignId('responsable_legal_id')->constrained('responsables_legaux')->cascadeOnDelete();
            $table->boolean('est_destinataire_documents')->default(true);
            $table->timestamps();

            $table->unique(['membre_id', 'responsable_legal_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membre_responsable');
    }
};
