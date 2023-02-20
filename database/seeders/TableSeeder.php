<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tables')->insert([
            'id' => 1,
            'restaurant_id' => 1,
            'status' => 'open',
            'created_at' => null,
            'updated_at' => null,
            'deleted_at' => null,
        ]);
    }
}
