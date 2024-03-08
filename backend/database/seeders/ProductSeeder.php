<?php

namespace Database\Seeders;

use Faker\Factory as Faker;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 20; $i++) {
            $product = new Product;

            $product->desc = $faker->name;
            $product->category = $faker->sentence(4);
            $product->stock = $faker->numberBetween(1, 100);
            $product->price = $faker->randomFloat(2, 1000, 1000000);

            $product->save();
        }
    }
}
