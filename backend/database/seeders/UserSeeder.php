<?php

namespace Database\Seeders;

use App\Models\User;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

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

        for ($i = 0; $i < 4; $i++) {
            $user = new User;

            $user->name = $faker->name;
            $user->email = $faker->email;
            $user->password = '123';

            $user->save();
        }
    }
}
