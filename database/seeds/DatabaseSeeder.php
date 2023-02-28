<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 1)->create()->each(function ($user) {
            for ($i=0;$i<10;$i++) {
                $user->posts()->save(factory(App\Post::class)->make());
            }
        });
    }
}
