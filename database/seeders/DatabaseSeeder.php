<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            CategorySeeder::class, // tambahkan ini
            AuthorSeeder::class,   // kalau mau seed author
            BookSeeder::class,     // tambahkan ini
        ]);
    }
}
