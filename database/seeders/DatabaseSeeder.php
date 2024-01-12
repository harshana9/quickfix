<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\DefaultUsersSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(DefaultUsersSeeder::class);
        $this->call(DefaultStatusSeeder::class);
        $this->call(DefaultVendorSeeder::class);
        $this->call(DefaultProductSeeder::class);
        $this->call(DefaultCarbonCopyPersonSeeder::class);
    }
}
