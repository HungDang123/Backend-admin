<?php

namespace Database\Seeders;

use Database\Seeders\ProductSeeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // RoleSeeder::class,
            // UserSeeder::class,
            // ProductSeeeder::class,
            // OrderSeeder::class
            PermissionSeeder::class,
            RolePermissionSeeder::class
        ]);
    }
}
