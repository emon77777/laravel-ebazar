<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SellerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sellers')->insert([
            'company_name'=>'Online Park',
            'first_name'=>'Online',
            'last_name'=>'Park',
            'password'=>bcrypt('seller22'),
            'image'=>'YsnkP5XCUMe6RZKNUx5tRIvzFOuJD8xPZFjlxPSR.png',
            'remember_token'=>'4OP3vjDScbnij0NmPgWRMy5Igioqywks24yCxR1PRnUSYY8O4XbkVdMoFOSt',
            'mobile'=>'01xxxxxxx',
            'email' => 'seller@maantheme.com',
            'gender' => '1',
            'address' => 'Bongshal,Dhaka',
            'business_address' => 'Bangshal Dhaka',
            'business_email' => 'onlinepark@gmail.com',
            'business_mobile' => '01854432212',
            'post_code' => '1000',
            'city' => 'Dhaka',
            'nid_no' => NULL,
            'passport_no' => NULL,
            'domain_name' => 'http://mybazarupdate.maantheme.com/',
            'domain_ssl_stat' => '0',
            'is_active'=>1,
            'is_approve' => 1,
            'is_suspended' => 0,
        ]);
    }
}
