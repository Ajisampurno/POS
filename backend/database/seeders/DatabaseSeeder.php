<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\PaymentSeeder;
use Database\Seeders\ProductSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        $this->call([
            //PaymentSeeder::class,
            ProductSeeder::class,
            //TransactionDetailSeeder::class,
            //TransactionSeeder::class,
            CartSeeder::class,
            //UserSeeder::class
        ]);
    }
}
