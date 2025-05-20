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
        Schema::table('orders', function (Blueprint $table) {
            // Add shipping column if it doesn't exist
            if (!Schema::hasColumn('orders', 'shipping')) {
                $table->decimal('shipping', 8, 2)->default(20.00)->after('tax');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop the shipping column if it exists
            if (Schema::hasColumn('orders', 'shipping')) {
                $table->dropColumn('shipping');
            }
        });
    }
};
