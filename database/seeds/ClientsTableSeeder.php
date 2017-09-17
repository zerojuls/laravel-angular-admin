<?php

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    CONST START = 0;
    CONST LIMIT = 50;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's clear the clients table first
        Client::truncate();

        // Let's make a fake clients
        for ($obj = self::START; $obj < self::LIMIT; $obj++) {
            $faker = Faker\Factory::create();

            Client::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->safeEmail,
                'trademark' => $faker->company,
                'phone' => (int)($faker->randomElement(['4','5','7'])).(rand ( 100000 , 999999 )),
                'mobile_phone' => (9).(rand ( 10000000 , 99999999 )),
            ]);
        }
    }
}
