<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\UserFactory;
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
        UserSeeder::class,
        UserFactory::class,
        // (éventuellement d’autres seeders plus tard)
    ]);
}

}
