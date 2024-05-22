<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('formulaires', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->softDeletes();

            $table->string('intitule', length: 200)->nullable(false);
            $table->string('description', length: 200)->nullable();
            $table->enum('secteur', ['energie', 'transport', 'fournisseur_logistique', 'dechet', 'alimentation', 'logement', 'amenagement', 'communication'])->nullable(false);
            $table->jsonb('formule')->nullable(false);
            $table->boolean('publie')->nullable(false)->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulaires');
    }
};
