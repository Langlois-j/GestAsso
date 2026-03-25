<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->date('date_naissance');
            $table->string('email', 255)->nullable();
            $table->string('telephone', 20)->nullable(); // 🔐 ciphersweet W-03
            $table->text('adresse')->nullable();          // 🔐 ciphersweet W-03
            $table->string('numero_licence_ffme', 50)->nullable()->index('idx_membres_licence');
            $table->string('saison_licence', 9)->nullable()->index('idx_membres_saison');
            $table->boolean('licence_verifiee_ffme')->default(false);
            $table->timestamp('licence_verifiee_at')->nullable();
            $table->enum('passeport_couleur', ['blanc','jaune','orange','vert','bleu','violet'])->nullable()->index('idx_membres_passeport');
            $table->date('passeport_valide_le')->nullable();
            $table->foreignId('passeport_validateur_id')->nullable()->constrained('membres')->nullOnDelete();
            $table->enum('passeport_source', ['api_ffme','manuel'])->default('manuel');
            $table->enum('garantie_ffme', ['BASE','BASE_PLUS','BASE_PLUS_PLUS'])->nullable();
            $table->string('photo', 255)->nullable();
            $table->text('commentaire_interne')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_active', 'deleted_at'], 'idx_membres_actif');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membres');
    }
};
