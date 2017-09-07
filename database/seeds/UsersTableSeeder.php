<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's clear the users table first
        User::truncate();

        // Let's make sure everyone has the same password and
        // let's hash it before the loop, or else our seeder
        // will be too slow.
        $password = Hash::make('12345678');

        User::create([
            'name' => 'admin',
            'email' => 'admin@zerojuls.com',
            'password' => $password,
            'api_token' => str_random(60),
        ]);
    }
}
