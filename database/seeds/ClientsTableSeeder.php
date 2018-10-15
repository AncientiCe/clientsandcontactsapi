<?php

use App\Client;
use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        Client::truncate();

        // Initialize the Faker package. We can use several different locales for it, so
        // let's use the german locale to play with it.
        $faker = \Faker\Factory::create('de_DE');

        // And now, let's create a few clients in our database:
        for ($i = 0; $i < 50; $i++) {
            Client::create([
                'first_name' => $faker->name,
                'email' => $faker->unique()->safeEmail
            ]);
        }
    }
}
