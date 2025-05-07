<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employe', function (Blueprint $table) {
            // Cette colonne reprend l'ID de l'utilisateur et devient la PK de la table employes
            $table->unsignedBigInteger('id_employe')->primary();

            // Exemple de champs propres à un employé
            $table->string('poste')->nullable();
            $table->date('date_embauche')->nullable();
            $table->decimal('salaire', 10, 2)->nullable();

            $table->timestamps();

            // Clé étrangère vers users.id_users avec cascade sur suppression
            $table->foreign('id_employe')
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
        Schema::dropIfExists('employes');
    }
}
