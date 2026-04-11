<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('brick_products', function (Blueprint $table) {
            $table->string('category')->nullable()->after('name');
            $table->string('image')->nullable()->after('description');
            $table->decimal('weight_kg', 8, 2)->nullable()->after('image');
            $table->string('dimensions_inch')->nullable()->after('weight_kg');
            // coverage_sqm: how many square metres ONE unit covers (e.g. 0.0167 for a standard brick)
            // This drives the quotation calculator: units_required = ceil(area / coverage_sqm)
            $table->decimal('coverage_sqm', 10, 6)->nullable()->after('dimensions_inch');
        });
    }

    public function down(): void
    {
        Schema::table('brick_products', function (Blueprint $table) {
            $table->dropColumn(['category', 'image', 'weight_kg', 'dimensions_inch', 'coverage_sqm']);
        });
    }
};
