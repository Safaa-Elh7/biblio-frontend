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
    Schema::create('reservation', function (Blueprint $table) {
        $table->bigIncrements('id_reservation');
        $table->dateTime('date_reservation')->useCurrent();
        $table->enum('statut', ['PENDING','NOTIFIED','CANCELLED'])
              ->default('PENDING');
        $table->unsignedBigInteger('id_client');
        $table->unsignedBigInteger('id_article');
        $table->timestamps();

        // FK vers client.id_client
        $table->foreign('id_client')
              ->references('id_client')->on('client')
              ->onDelete('cascade');

        // FK vers article.id_article
        $table->foreign('id_article')
              ->references('id_article')->on('article')
              ->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation');
    }
};
