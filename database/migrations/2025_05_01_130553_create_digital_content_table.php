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
        Schema::create('digital_content', function (Blueprint $table) {
            $table->bigIncrements('id_content');
            $table->unsignedBigInteger('id_article');
            $table->string('url', 255);
            $table->enum('format', ['PDF','EPUB']);
            $table->timestamps();
    
            // FK vers article.id_article
            $table->foreign('id_article')
                  ->references('id_article')->on('article')
                  ->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digital_content');
    }
};
