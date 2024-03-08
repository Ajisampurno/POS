<?php

namespace Database\Seeders;

use App\Models\Payment;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
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
            $payment = new Payment;

            $payment->cash = $faker->randomFloat(2, 1000, 1000000);
            $payment->metode = $faker->randomElement(['Debit', 'Credit', 'Qris', 'Cash']);
            $payment->number_card = $faker->randomNumber(8);
            $payment->code_ref = $faker->randomNumber(6);

            $payment->save();
        }
    }
}
