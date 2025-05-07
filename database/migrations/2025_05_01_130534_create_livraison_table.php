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
        Schema::create('livraison', function (Blueprint $table) {
            $table->bigIncrements('id_livraison');
            $table->dateTime('date_livraison')->useCurrent();
            $table->enum('statut_livraison', ['PENDING','SHIPPED','DELIVERED','CANCELLED'])
                  ->default('PENDING');
            $table->unsignedBigInteger('id_commande');
            $table->timestamps();
    
            // FK vers commande.id_commande
            $table->foreign('id_commande')
                  ->references('id_commande')->on('commande')
                  ->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livraison');
    }
};
