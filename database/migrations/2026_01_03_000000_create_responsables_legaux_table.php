<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('responsables_legaux', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('type', ['parent','tuteur_legal','educateur','referent_institutionnel','autre']);
            $table->string('type_libre', 100)->nullable();
            $table->string('nom', 100);
            $table->string('prenom', 100)->nullable();
            $table->boolean('est_personne_morale')->default(false);
            $table->string('contact_referent', 200)->nullable();
            $table->string('email', 255)->nullable();   // 🔐 ciphersweet W-03
            $table->string('telephone', 20)->nullable(); // 🔐 ciphersweet W-03
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('responsables_legaux');
    }
};
