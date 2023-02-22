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
                'username' => 'super admin',
                'password' => Hash::make('admin123', ['rounds' => '10']),
                'role_id' => 1,
                'restaurant_id' => null,
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 1,
                'name' => 'kasir 1',
                'username' => 'kasir1',
                'password' => Hash::make('test123', ['rounds' => '10']),
                'role_id' => 2,
                'restaurant_id' => null,
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ]
        ]);
    }
}
