<?php

namespace Database\Seeders;

use App\Models\User;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 1; $i++) {
            $user = new User;

            $user->name = 'Aji';
            $user->email = 'ajisampurno121@gmail.com';
            $user->password = Hash::make('11111111');

            $user->save();
        }
    }
}
