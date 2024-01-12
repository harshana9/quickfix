<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class DefaultProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create(
            [
                'name' => 'Test Product',
                'vendor' => '1',
                'connection_type' => 'GPRS',
                'description' => 'This is a test Product'
            ]
        );
    }
}
