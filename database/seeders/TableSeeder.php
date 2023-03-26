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
            [
                'id' => 1,
                'restaurant_id' => 1,
                'table_number' => 1,
                'status' => 'open',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
                'session_id' => 1,
            ],
            [
                'id' => 2,
                'restaurant_id' => 1,
                'table_number' => 2,
                'status' => 'ongoing',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
                'session_id' => 1,
            ],
            [
                'id' => 3,
                'restaurant_id' => 1,
                'table_number' => 3,
                'status' => 'close',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
                'session_id' => 1,
            ],
            [
                'id' => 4,
                'restaurant_id' => 1,
                'table_number' => 4,
                'status' => 'reserved',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
                'session_id' => 1,
            ],
        ]);
    }
}
