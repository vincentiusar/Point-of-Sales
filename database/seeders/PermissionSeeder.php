<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            [
                'id' => 1,
                'name' => 'Add Table',
                'key' => 'add-table',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'name' => 'Get All Restaurant',
                'key' => 'get-all-restaurant',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 3,
                'name' => 'Get One Restaurant',
                'key' => 'get-one-restaurant',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 4,
                'name' => 'Update Restaurant',
                'key' => 'update-restaurant',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 5,
                'name' => 'Super Admin',
                'key' => 'super-admin',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 6,
                'name' => 'Admin',
                'key' => 'admin',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}
