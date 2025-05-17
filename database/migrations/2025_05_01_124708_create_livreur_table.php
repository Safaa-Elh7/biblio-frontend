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
        Schema::create('livreur', function (Blueprint $table) {
            // PK identique à id_personne
            $table->unsignedBigInteger('id_livreur')->primary();
            $table->string('zone_livraison', 100)->nullable();
            $table->string('moyen_transport', 100)->nullable();
            $table->boolean('disponibilite')->default(true);
            $table->decimal('rating', 3, 2)->nullable()->default(0.00);
            $table->timestamps();
    
            // FK vers personne.id_personne
            $table->foreign('id_livreur')
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
        Schema::dropIfExists('livreur');
    }
};
