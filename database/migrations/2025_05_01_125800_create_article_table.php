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
        Schema::create('article', function (Blueprint $table) {
            $table->bigIncrements('id_article');
            $table->string('image', 255)->nullable();
            $table->string('titre', 255);
            $table->year('annee_pub')->nullable();
            $table->unsignedInteger('qte')->default(1);
            $table->decimal('prix_emprunt', 8, 2)->default(0.00);

            // Nouveaux champs
            $table->string('description', 500)->nullable();
            $table->string('langue', 10)->nullable();
            $table->string('auteur', 255)->nullable();

            $table->unsignedBigInteger('id_categorie')->nullable();
            $table->timestamps();
    
            // FK vers categorie.id_categorie
            $table->foreign('id_categorie')
                  ->references('id_categorie')->on('categorie')
                  ->onDelete('set null');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article');
    }
};
