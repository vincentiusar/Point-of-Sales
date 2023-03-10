<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('food')->insert([
            [
                'id' => 1,
                'restaurant_id' => 1,
                'name' => 'makanan baru',
                'description' => 'makanan ini baru dibuat',
                'quantity' => 10,
                'price' => '10000',
                'category' => 'main dishes',
                'image' => ''
            ],
            [
                'id' => 2,
                'restaurant_id' => 1,
                'name' => 'makanan lama',
                'description' => 'makanan lamaaaa',
                'quantity' => 10,
                'price' => '25000',
                'category' => 'main dishes',
                'image' => ''
            ]
        ]);
    }
}
