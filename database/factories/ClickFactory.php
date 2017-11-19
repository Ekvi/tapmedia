<?php

use App\Models\Click;
use Faker\Generator as Faker;

$click = $factory->define(Click::class, function (Faker $faker) {
    return [
        'id' => $faker->uuid,
        'ip' => '192.168.0.1',
        'ua' => 'Opera',
        'ref' => 'http://test.com',
        'param1' => 'param1',
        'param2' => str_random(10),
        'error' => rand(1, 10)
    ];
});

$click = $factory->defineAs(Click::class, 'withGoogle', function (Faker $faker) use($factory) {
    return [
        'id' => $faker->uuid,
        'ip' => '192.168.0.1',
        'ua' => 'Opera/8.25 (Windows NT 5.1; en-US) Presto/2.9.188 Version/10.00',
        'ref' => 'http://google.com',
        'param1' => 'param1',
        'param2' => str_random(10),
        'error' => rand(1, 10)
    ];
});

$click = $factory->defineAs(Click::class, 'statusTest', function (Faker $faker) {
    return [
        'id' => $faker->uuid,
        'ip' => '127.0.0.1',
        'ua' => 'Mozilla/5.0 (X11; Linux x86_64; rv:57.0) Gecko/20100101 Firefox/57.0',
        'ref' => 'http://tapmedia.dev',
        'param1' => 'param1',
        'param2' => str_random(10),
        'error' => rand(1, 10)
    ];
});