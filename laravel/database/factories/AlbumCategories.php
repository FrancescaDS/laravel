<?php

use Faker\Generator as Faker;
use App\Models\AlbumCategory;

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
    'transport'
];
foreach ($cats as $cat) {

    factory(App\Models\AlbumCategory::class,5)->create();


    AlbumCategory::create(
        ['category_name' => $cat]
    );
}



$factory->define(AlbumCategory::class, function (Faker $faker) {
    return [
        'category_name' => $faker->text(16),
        'user_id' => 31
    ];
});
