<?php

use Illuminate\Database\Seeder;
use App\User;

class UserMetasTableSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        foreach ($users as $user)
        {
            $user->meta()->save(factory(App\UserMeta::class)->make());
        }
    }
}
