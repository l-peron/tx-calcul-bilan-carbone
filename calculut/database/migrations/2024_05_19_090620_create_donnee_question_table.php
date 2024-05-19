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
        Schema::create('donnee_question', function (Blueprint $table) {
            $table->foreignUuid('question_id');
            $table->foreign('question_id')->references('id')->on('questions');

            $table->foreignUuid('donnee_id');
            $table->foreign('donnee_id')->references('id')->on('donnees');

            $table->primary(['question_id', 'donnee_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donnee_question');
    }
};
