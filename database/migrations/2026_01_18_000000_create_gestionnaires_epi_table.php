<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gestionnaires_epi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membre_id')->unique()->constrained('membres')->cascadeOnDelete();
            $table->boolean('est_principal')->default(false);
            $table->date('designe_le');
            $table->foreignId('designe_par_id')->constrained('membres')->restrictOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gestionnaires_epi');
    }
};
