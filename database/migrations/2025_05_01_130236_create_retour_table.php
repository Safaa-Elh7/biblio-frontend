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
    Schema::create('retour', function (Blueprint $table) {
        $table->bigIncrements('id_retour');
        $table->dateTime('date_retour_reelle');
        $table->enum('etat_livre', ['GOOD','DAMAGED','LOST'])
              ->default('GOOD');
        $table->boolean('payback')
              ->default(false);
        $table->unsignedBigInteger('id_emprunt');
        $table->unsignedBigInteger('id_employe')->nullable();
        $table->timestamps();

        // FK vers emprunt.id_emprunt
        $table->foreign('id_emprunt')
              ->references('id_emprunt')->on('emprunt')
              ->onDelete('cascade');

        $table->foreign('id_employe')
              ->references('id_employe')->on('employe')
              ->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retour');
    }
};
