<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::find(1)->permissions()->attach([1, 2, 3, 4, 5, 6, 7, 8]);
        Role::find(2)->permissions()->attach([1, 2, 3, 4, 5, 6, 7, 8]);
        Role::find(3)->permissions()->attach([1, 2, 3, 4, 5, 6, 7, 8]);
    }
}
