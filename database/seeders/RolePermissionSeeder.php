<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('role_permissions')->insert([
            [
                'id' => 1,
                'role_id' => 1,
                'permission_id' => 1,
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'role_id' => 1,
                'permission_id' => 2,
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 3,
                'role_id' => 1,
                'permission_id' => 3,
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 4,
                'role_id' => 1,
                'permission_id' => 4,
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 5,
                'role_id' => 1,
                'permission_id' => 5,
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}
