<?php

use Carbon\Carbon;
use App\Models\Album;
use App\Models\Photo;
use App\User;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Album::class, function (Faker $faker) {
    return [
        'album_name' => $faker->name,
        'description' => $faker->text(128),
        //'user_id' => User::first()->id
        'user_id' => User::inRandomOrder()->first()->id
    ];
});

$factory->define(App\Models\Photo::class, function (Faker $faker) {
    $cats = ['abstract',
        'animals',
        'business',
        'cats',
        'city',
        'food',
        'nightlife',
        'fashion',
        'people',
        'nature',
        'sports',
        'technics',
        'transport'];

    return [
        'album_id' => Album::inRandomOrder()->first()->id,
        'name' => $faker->text(64),
        'description' => $faker->text(128),
        'image_path' => $faker->imageUrl(640,480,$faker->randomElement($cats))
    ];
});