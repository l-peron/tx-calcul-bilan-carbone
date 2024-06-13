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
        Schema::create('donnees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();

            $table->string('intitule', length: 200)->nullable(false);
            $table->string('description', length: 200)->nullable();
            $table->float('valeur')->nullable(false);
            $table->string('unite', length: 200)->nullable(false);
            $table->string('source', length: 200)->nullable(false);
            $table->enum('metrique', ['CO2'])->default('CO2')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donnees');
    }
};
