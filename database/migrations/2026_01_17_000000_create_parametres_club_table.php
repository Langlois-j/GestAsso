<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parametres_club', function (Blueprint $table) {
            $table->id(); // Toujours id=1 en V1
            $table->string('nom_club', 200);
            $table->string('numero_affiliation', 50)->nullable();
            $table->date('date_reaffiliation')->nullable();
            $table->string('api_url', 255)->default('https://api.core.myffme.fr/');
            $table->string('api_key', 255)->nullable();       // 🔐 ciphersweet W-03
            $table->enum('api_statut', ['connecte','deconnecte','inconnu'])->default('inconnu');
            $table->timestamp('api_derniere_synchro')->nullable();
            $table->string('smtp_host', 255)->nullable();
            $table->smallInteger('smtp_port')->nullable();
            $table->string('smtp_user', 255)->nullable();
            $table->string('smtp_password', 255)->nullable(); // 🔐 ciphersweet W-03
            $table->string('email_president', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parametres_club');
    }
};
