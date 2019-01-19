<?php

use Faker\Generator as Faker;

$factory->define(App\UserMeta::class, function (Faker $faker) {
    for ($i=0; $i < 3; $i++) { 
        $array[] = [
            'url' => $faker->url,
            'title' => $faker->domainWord
        ];
    }
    $gender = ['male', 'female'];
    return [
        'full_name' => $faker->name,
        'nickname' => $faker->firstName(),
        'description' => $faker->text(),
        'avatar_path' => null,
        'birthday' => $faker->date(),
        'gender' => $gender[rand(0, 1)],
        'number' => $faker->phoneNumber,
        'address' => $faker->address,
        'social_links' => $array,
    ];
});
