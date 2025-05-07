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
    Schema::create('bibliothecaire', function (Blueprint $table) {
        // La PK est la même que la personne associée
        $table->unsignedBigInteger('id_bibliothecaire')->primary();
        $table->timestamps();

        $table->foreign('id_bibliothecaire')
              ->references('id_users')
              ->on('users')
              ->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bibliothecaire');
    }
};
