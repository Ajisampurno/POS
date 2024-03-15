<?php

namespace Database\Seeders;

use App\Models\Cart;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 12; $i++) {
            $cart = new Cart;
            $cart->product_id = $faker->numberBetween(1, 20);
            $cart->qty = 1;

            $cart->save();
        }
    }
}
