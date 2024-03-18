<?php

namespace Database\Seeders;

use App\Models\TransactionDetail;
use Faker\Factory as Faker;

use Illuminate\Database\Seeder;

class TransactionDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 40; $i++) {
            $transaction_detail = new TransactionDetail();

            $transaction_detail->transaction_id = $faker->numberBetween(1, 20);
            $transaction_detail->product_id = $faker->numberBetween(1, 20);
            $transaction_detail->qty = $faker->numberBetween(1, 20);
            $transaction_detail->price = $faker->randomFloat(2, 1000, 1000000);

            $transaction_detail->save();
        }
    }
}
