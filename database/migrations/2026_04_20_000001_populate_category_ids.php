<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Define the categories
        $categories = [
            'Bricks',
            'Floor Tiles',
            'Decorative Bricks',
            'Ventilators',
            'Other',
        ];

        // Create ProductCategory records if they don't exist
        foreach ($categories as $categoryName) {
            $exists = DB::table('product_categories')
                ->where('name', $categoryName)
                ->exists();

            if (!$exists) {
                DB::table('product_categories')->insert([
                    'name' => $categoryName,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reset category_id to null
        DB::table('brick_products')->update(['category_id' => null]);
        
        // Optionally delete the product categories
        // DB::table('product_categories')->delete();
    }
};
