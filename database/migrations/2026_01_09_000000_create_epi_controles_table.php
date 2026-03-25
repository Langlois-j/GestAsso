<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('epi_controles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('epi_id')->constrained('epis')->cascadeOnDelete();
            $table->foreignId('controleur_id')->constrained('membres')->restrictOnDelete();
            $table->date('date_controle');
            $table->enum('type_controle', ['annuel','routine_avant','routine_apres']);
            $table->enum('resultat', ['conforme','non_conforme','reforme']);
            $table->text('commentaire')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('epi_controles');
    }
};
