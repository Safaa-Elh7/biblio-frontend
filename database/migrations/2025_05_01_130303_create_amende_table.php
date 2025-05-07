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
        Schema::create('amende', function (Blueprint $table) {
            $table->bigIncrements('id_amende');
            $table->decimal('montant', 8, 2);
            $table->string('raison', 255)->nullable();
            $table->date('date_emission')->useCurrent();
            $table->boolean('payee')->default(false);
            $table->unsignedBigInteger('id_retour');
            $table->timestamps();
    
            // FK vers retour.id_retour
            $table->foreign('id_retour')
                  ->references('id_retour')->on('retour')
                  ->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amende');
    }
};
