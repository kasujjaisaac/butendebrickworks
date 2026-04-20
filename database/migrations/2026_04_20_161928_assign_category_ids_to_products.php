<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Bricks (id=1)
        DB::table('brick_products')->whereIn('name', [
            'Plain Brick',
            'Half Brick',
            'Standard Brick Grooved',
            'Arch Brick',
            'Pillar Brick',
            'Corner Brick',
            'T Brick',
        ])->update(['category_id' => 1]);

        // Floor Tiles (id=2)
        DB::table('brick_products')->whereIn('name', [
            'Standard Floor Tile',
            'Courtyard Tile',
            'Veranda Tile',
            'Interior Floor Tile',
            'Quarry Tile',
        ])->update(['category_id' => 2]);

        // Decorative Bricks (id=3)
        DB::table('brick_products')->whereIn('name', [
            'Double Pompe',
            'Malta',
            'Malta II',
            'Single Pompe',
            'Spina',
            'Roofing Tile I',
            'Roofing Tile II',
        ])->update(['category_id' => 3]);

        // Ventilators (id=4)
        DB::table('brick_products')->whereIn('name', [
            'Star Ventilator',
            'O Ventilator',
            'Malta Ventilator',
            'Quarter Circle Ventilator',
            'X Ventilator',
        ])->update(['category_id' => 4]);

        // Other (id=5)
        DB::table('brick_products')->whereIn('name', [
            'Max Pan',
            'Clay Stove',
            'Partitioning Block',
            'KASUJJA ISAAC',
        ])->update(['category_id' => 5]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('brick_products')->update(['category_id' => null]);
    }
};

