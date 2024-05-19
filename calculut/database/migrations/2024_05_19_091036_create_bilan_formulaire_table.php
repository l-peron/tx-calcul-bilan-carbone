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
        Schema::create('bilan_formulaire', function (Blueprint $table) {
            $table->id();

            $table->foreignUuid('bilan_id');
            $table->foreign('bilan_id')->references('id')->on('bilans');

            $table->foreignUuid('formulaire_id');
            $table->foreign('formulaire_id')->references('id')->on('formulaires');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bilan_formulaire');
    }
};
