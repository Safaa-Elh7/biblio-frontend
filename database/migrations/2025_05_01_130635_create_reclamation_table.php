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
        Schema::create('reclamation', function (Blueprint $table) {
            $table->bigIncrements('id_reclamation');
            $table->string('objet', 150);
            $table->text('raison')->nullable();
            $table->dateTime('date_reclamation')->useCurrent();
            $table->enum('statut', ['OPEN','IN_PROGRESS','CLOSED'])
                  ->default('OPEN');
            $table->unsignedBigInteger('id_client');
            $table->timestamps();
    
            // FK vers client.id_client
            $table->foreign('id_client')
                  ->references('id_client')->on('client')
                  ->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reclamation');
    }
};
