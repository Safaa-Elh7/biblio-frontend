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
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id_role');              // clé primaire standard
            $table->string('code', 30)->unique();     // nom du rôle
            $table->string('guard_name')->default('web'); // guard Laravel
            $table->string('libelle', 100)->nullable();   // ta description si tu veux
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
