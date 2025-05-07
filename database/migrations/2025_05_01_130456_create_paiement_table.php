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
    Schema::create('paiement', function (Blueprint $table) {
        $table->bigIncrements('id_paiement');
        $table->enum('methode', ['CARTE','PAYPAL']);
        $table->decimal('montant', 10, 2);
        $table->dateTime('date_paiement')->useCurrent();
        $table->enum('statut', ['PENDING','COMPLETED','FAILED'])
              ->default('PENDING');
        $table->unsignedBigInteger('reference_id');
        $table->unsignedBigInteger('id_commande');
        $table->timestamps();

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
        Schema::dropIfExists('paiement');
    }
};
