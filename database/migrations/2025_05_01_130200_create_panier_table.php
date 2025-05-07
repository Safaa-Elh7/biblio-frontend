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
        Schema::create('panier', function (Blueprint $table) {
            $table->bigIncrements('id_panier');
            $table->unsignedBigInteger('id_client');
            $table->decimal('total', 10, 2)->default(0.00);
            $table->unsignedBigInteger('id_article');
            $table->timestamps();

            // FK vers client.id_client
            $table->foreign('id_client')
                  ->references('id_client')->on('client')
                  ->onDelete('cascade');

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
        Schema::dropIfExists('panier');
    }
};
