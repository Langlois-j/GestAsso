<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('creneau_absences_responsable', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creneau_id')->constrained('creneaux')->cascadeOnDelete();
            $table->foreignId('responsable_id')->constrained('membres')->restrictOnDelete();
            $table->timestamp('signale_le')->useCurrent();
            $table->foreignId('remplacant_id')->nullable()->constrained('membres')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('creneau_absences_responsable');
    }
};
