<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('restaurants')->insert([
            [
                'id' => 1,
                'name' => 'ada namanya',
                'description' => 'restoran yang bisa buat orang sentolop',
                'address' => 'jalan sentolop raya',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'name' => 'ASTAGOT',
                'description' => 'Resto ini ganti nama',
                'address' => 'adadda',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}
