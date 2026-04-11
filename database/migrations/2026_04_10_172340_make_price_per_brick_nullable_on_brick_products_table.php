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
        Schema::table('brick_products', function (Blueprint $table) {
            $table->decimal('price_per_brick', 10, 2)->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brick_products', function (Blueprint $table) {
            $table->decimal('price_per_brick', 10, 2)->nullable(false)->change();
        });
    }
};
