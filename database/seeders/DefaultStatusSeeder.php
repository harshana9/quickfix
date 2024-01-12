<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class DefaultStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::create(
            [
                'status_name' => 'New-Vendor Informed',
                'description' => 'System Status. New record auto mail sent.',
                'auth_required' => false
            ]
        );

        Status::create(
            [
                'status_name' => 'Deleted',
                'description' => 'User deleted the record.',
                'auth_required' => true
            ]
        );

        Status::create(
            [
                'status_name' => 'Compleated',
                'description' => 'Job done. error fixed/ sutable action taken.',
                'auth_required' => true
            ]
        );
    }
}
