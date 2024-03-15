<?php

namespace Database\Seeders;

use Faker\Factory as Faker;

use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
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
            $transaction = new Transaction;
            $transaction->payment_id = $faker->numberBetween(1, 20);
            $transaction->product_id = $faker->numberBetween(1, 20);
            $transaction->qty = $faker->numberBetween(1, 20);

            $transaction->save();
        }
    }
}
