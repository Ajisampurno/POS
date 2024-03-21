<?php

namespace Database\Seeders;

use App\Models\Payment;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

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
        $uuid = Uuid::uuid4()->toString();

        for ($i = 0; $i < 20; $i++) {
            $payment = new Payment;

            $payment->metode = $faker->randomElement(['Debit', 'Credit', 'Qris', 'Cash']);
            $payment->number_card = $faker->randomNumber(8);
            $payment->code_ref = $faker->randomNumber(6);
            $payment->save();
        }
    }
}
