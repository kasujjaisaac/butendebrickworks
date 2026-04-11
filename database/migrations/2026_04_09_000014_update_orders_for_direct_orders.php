<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Make quotation_id nullable so direct orders don't require one
            $table->foreignId('quotation_id')->nullable()->change();

            // Direct-order fields
            $table->foreignId('brick_product_id')->nullable()->constrained('brick_products')->nullOnDelete()->after('quotation_id');
            $table->unsignedInteger('quantity')->nullable()->after('brick_product_id');
            $table->text('delivery_address')->nullable()->after('quantity');
            $table->text('notes')->nullable()->after('delivery_address');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['brick_product_id']);
            $table->dropColumn(['brick_product_id', 'quantity', 'delivery_address', 'notes']);
            $table->foreignId('quotation_id')->nullable(false)->change();
        });
    }
};
