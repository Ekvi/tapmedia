<?php

use App\Models\BadDomain;
use Faker\Generator as Faker;

$google = $factory->defineAs(BadDomain::class, 'google', function (Faker $faker) {
    return [
        'name' => 'http://google.com',
    ];
});

$gmail = $factory->defineAs(BadDomain::class, 'gmail', function (Faker $faker) {
    return [
        'name' => 'http://gmail.com',
    ];
});

$gmail = $factory->defineAs(BadDomain::class, 'tapmedia', function (Faker $faker) {
    return [
        'name' => 'http://tapmedia.dev',
    ];
});
