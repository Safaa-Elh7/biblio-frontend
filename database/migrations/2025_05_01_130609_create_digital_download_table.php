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
    Schema::create('digital_download', function (Blueprint $table) {
        $table->bigIncrements('id_download');
        $table->unsignedBigInteger('id_client');
        $table->unsignedBigInteger('id_content');
        $table->unsignedBigInteger('payment_id');
        $table->dateTime('date_download')->useCurrent();
        $table->timestamps();

        // FK vers client.id_client
        $table->foreign('id_client')
              ->references('id_client')->on('client')
              ->onDelete('cascade');

        // FK vers digital_content.id_content
        $table->foreign('id_content')
              ->references('id_content')->on('digital_content')
              ->onDelete('cascade');

        // FK vers paiement.id_paiement
        $table->foreign('payment_id')
              ->references('id_paiement')->on('paiement')
              ->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digital_download');
    }
};
