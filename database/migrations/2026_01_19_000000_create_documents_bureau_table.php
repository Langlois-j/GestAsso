<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents_bureau', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['statuts','reglement_interieur','cer','autre']);
            $table->string('titre', 200);
            $table->string('fichier_path', 255);
            $table->date('date_signature')->nullable();
            $table->smallInteger('version')->default(1);
            $table->boolean('is_actif')->default(true);
            $table->foreignId('uploaded_par_id')->constrained('membres')->restrictOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents_bureau');
    }
};
