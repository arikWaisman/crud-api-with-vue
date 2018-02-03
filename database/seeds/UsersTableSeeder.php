<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Behavior;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::truncate();
        // $faker = \Faker\Factory::create();
        // foreach (range(1, 50) as $index) {
        //     User::create([
        //         'name' => $faker->userName(),
        //         'email' => $faker->email,
        //         'password' => $faker->password
        //     ]);
        // }

        // factory(App\User::class, 3)->create()->each(function ($user) {
        //     for ($i = 0; $i < 3; $i++) {

        //         $faker = \Faker\Factory::create();

        //         Behavior::create([
        //             'breakfast' => $faker->word,
        //             'daily_routine' => $faker->word,
        //             'feeling' => $faker->word,
        //             'user_id' => $user->id
        //         ]);
        //     }
        // });

        factory(App\User::class, 2)->create()->each(
            function ($user) {
                factory(App\Behavior::class, 3)->create(['user_id' => $user->id]);
            }
        );
    }
}
