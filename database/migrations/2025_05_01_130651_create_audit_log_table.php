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
        Schema::create('audit_log', function (Blueprint $table) {
            $table->bigIncrements('id_log');
            $table->string('table_name', 100);
            $table->unsignedBigInteger('record_id');
            $table->string('action', 30);
            $table->unsignedBigInteger('id_client')->nullable();
            $table->dateTime('timestamp')->useCurrent();
    
            // FK vers client.id_client (optionnel)
            $table->foreign('id_client')
                  ->references('id_client')->on('client')
                  ->onDelete('set null');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_log');
    }
};
