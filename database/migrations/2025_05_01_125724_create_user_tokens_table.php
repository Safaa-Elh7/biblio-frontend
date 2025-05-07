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
    Schema::create('user_tokens', function (Blueprint $table) {
        $table->bigIncrements('id_token');
        $table->unsignedBigInteger('id_user');
        $table->string('token');
        $table->dateTime('expires_at');
        $table->dateTime('created_at')->useCurrent();

        $table->foreign('id_user')
              ->references('id_utilisateur')
              ->on('utilisateur')
              ->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_tokens');
    }
};
