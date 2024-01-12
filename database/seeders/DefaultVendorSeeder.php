<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;

class DefaultVendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vendor::create(
            [
                'name' => 'Test',
                'main_email' => 'mail.harshana.lk@gmail.com',
                'cc_email_1' => 'ravindu84lakmal@gmail.com',
                'cc_email_2' => null,
                'cc_email_3' => null,
                'contact_1' => '0773270038',
                'contact_2' => null,
                'address' =>null
            ]
        );

        Vendor::create(
            [
                'name' => 'CBA',
                'main_email' => 'cbapos@cba.lk',
                'cc_email_1' => 'amila@cba.lk',
                'cc_email_2' => 'hasantha.r@cba.lk',
                'cc_email_3' => 'malindu.j@cba.lk',
                'contact_1' => '0112714141',
                'contact_2' => null,
                'address' =>null
            ]
        );

        Vendor::create(
            [
                'name' => 'EPIC',
                'main_email' => 'support@epiclanka.net',
                'cc_email_1' => 'ruwan_w@epiclanka.net',
                'cc_email_2' => 'shiv_f@epiclanka.net',
                'cc_email_3' => null,
                'contact_1' => '0112887787',
                'contact_2' => null,
                'address' =>null
            ]
        );

        Vendor::create(
            [
                'name' => 'AIKEN',
                'main_email' => 'poshelp@aiken.com.lk',
                'cc_email_1' => 'asanka@aiken.com.lk',
                'cc_email_2' => 'dushanthaw@aiken.com.lk',
                'cc_email_3' => 'tharusha@aiken.com.lk',
                'contact_1' => '0701420420',
                'contact_2' => null,
                'address' =>null
            ]
        );

        Vendor::create(
            [
                'name' => 'Payable',
                'main_email' => 'shamroz@payable.lk',
                'cc_email_1' => 'maheshika@payable.lk',
                'cc_email_2' => null,
                'cc_email_3' => null,
                'contact_1' => '0117776777',
                'contact_2' => null,
                'address' =>null
            ]
        );
    }
}
