<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ast_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sortie_participant_id')->constrained('sortie_participants')->cascadeOnDelete();
            $table->enum('type_flux', ['numerique','papier_scan']);
            $table->string('fichier_path', 255)->nullable();
            $table->timestamp('signe_le')->nullable();      // 🔐 ciphersweet W-03 — L-06
            $table->string('ip_signature', 45)->nullable(); // 🔐 ciphersweet W-03 — L-05/L-06
            $table->timestamps();
            $table->softDeletes(); // Conservation 10 ans — L-05
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ast_documents');
    }
};
