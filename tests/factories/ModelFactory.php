<?php

$factory->define(\ArjanWestdorp\Exposable\Test\Stubs\Attachment::class, function (Faker\Generator $faker) {
    return [
        'name' => 'test.pdf',
        'content' => $faker->text(),
    ];
});

$factory->define(\ArjanWestdorp\Exposable\Test\Stubs\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
