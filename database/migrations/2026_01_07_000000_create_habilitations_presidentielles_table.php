<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('habilitations_presidentielles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membre_id')->constrained('membres')->cascadeOnDelete();
            $table->foreignId('president_id')->constrained('membres')->restrictOnDelete();
            $table->text('perimetre');
            $table->date('date_designation');
            $table->date('date_expiration')->nullable();
            $table->text('commentaire')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['membre_id', 'is_active'], 'idx_habilitations_membre');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('habilitations_presidentielles');
    }
};
