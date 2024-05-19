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
        Schema::table('questions', function (Blueprint $table) {
            $table->foreignUuid('formulaire_id');
            $table->foreign('formulaire_id')->references('id')->on('formulaires')->cascadeOnDelete();
        });

        Schema::table('enregistrement_finalises', function (Blueprint $table) {
            $table->foreignUuid('bilan_id');
            $table->foreign('bilan_id')->references('id')->on('bilans')->cascadeOnDelete();
        });

        Schema::table('evenements', function (Blueprint $table) {
            $table->foreignUuid('bilan_id');
            $table->foreign('bilan_id')->references('id')->on('bilans')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('formulaire_id');
        });

        Schema::table('enregistrement_finalises', function (Blueprint $table) {
            $table->dropColumn('bilan_id');
        });

        Schema::table('evenements', function (Blueprint $table) {
            $table->dropColumn('bilan_id');
        });
    }
};
