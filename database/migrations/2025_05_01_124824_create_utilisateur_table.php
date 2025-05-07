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
        Schema::create('utilisateur', function (Blueprint $table) {
            $table->bigIncrements('id_utilisateur');
            $table->unsignedBigInteger('id');         // plus de ->after()
            $table->string('email', 150)->unique();
            $table->string('mot_de_passe');
            $table->unsignedBigInteger('id_role');
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
    
            // FK si souhaitée, directement ici :
            $table->foreign('id_utilisateur')
                  ->references('id_users')
                  ->on('users')
                  ->cascadeOnDelete();
                  $table->foreign('id_role')
              ->references('id_role')->on('roles')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateur');
    }
};
