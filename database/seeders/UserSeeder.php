<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'super admin',
                'username' => 'admin',
                'password' => Hash::make('admin123', ['rounds' => '10']),
                'role_id' => 1,
                'restaurant_id' => 1,
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'name' => 'admin1',
                'username' => 'admin1',
                'password' => Hash::make('admin123', ['rounds' => '10']),
                'role_id' => 2,
                'restaurant_id' => 1,
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 3,
                'name' => 'kasir 1',
                'username' => 'kasir1',
                'password' => Hash::make('test123', ['rounds' => '10']),
                'role_id' => 3,
                'restaurant_id' => 1,
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ]
        ]);
    }
}
