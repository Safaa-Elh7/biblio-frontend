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
    Schema::create('commande', function (Blueprint $table) {
        $table->bigIncrements('id_commande');
        $table->unsignedBigInteger('id_panier');
        $table->dateTime('date_commande')->useCurrent();
        $table->decimal('total_complet', 10, 2);
        $table->decimal('total_avance', 10, 2)->default(0.00);
        $table->unsignedBigInteger('id_emprunt')->nullable();
        $table->timestamps();

       
              $table->foreign('id_emprunt')
                  ->references('id_emprunt')->on('emprunt')
                  ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commande');
    }
};
