<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmailCarbonCopyPerson;

class DefaultCarbonCopyPersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmailCarbonCopyPerson::create(
            [
                'person' => 'Nuwan Priyanga',
                'email' => 'mail.harshana.lk@gmail.com',
                'cc_level' => 2,
            ]
        );
    }
}
//'email' => 'nuwank@peoplesbank.lk',