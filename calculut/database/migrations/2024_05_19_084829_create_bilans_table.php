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
        Schema::create('bilans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->softDeletes();

            $table->string('intitule', length: 200)->nullable(false);
            $table->enum('type', ['event'])->default('event')->nullable(false);
            $table->string('auteur', length: 200)->nullable(false);
            $table->string('asso', length: 200)->nullable(false);
            $table->string('pole_asso', length: 200)->nullable(false);
            $table->jsonb('enregistrement')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bilans');
    }
};
