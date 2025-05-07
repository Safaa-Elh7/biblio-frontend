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
    Schema::create('emprunt', function (Blueprint $table) {
        $table->bigIncrements('id_emprunt');
        $table->date('date_emprunt')->useCurrent();
        $table->date('date_retour_prevue');
        $table->enum('etat', ['BORROWED','RETURNED','OVERDUE'])
              ->default('BORROWED');
        $table->unsignedBigInteger('id_client');
        $table->unsignedBigInteger('id_article');
         $table->unsignedBigInteger('id_panier')->nullable();

         // Nouveau champ total
         $table->decimal('total', 10, 2)->default(0.00);
        $table->unsignedInteger('nb_renouvellements')->default(0);
        $table->timestamps();

        // FK vers client.id_client
        $table->foreign('id_client')
              ->references('id_client')->on('client')
              ->onDelete('cascade');

              $table->foreign('id_panier')
                  ->references('id_panier')->on('panier')
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
        Schema::dropIfExists('emprunt');
    }
};
