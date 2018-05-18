<?php

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

$factory->define(App\Models\User::class, function (Faker $faker) {
    $lastName = collect(['Nguyễn', 'Phạm', 'Lê', 'Trần', 'Hoàng', 'Huỳnh', 'Phan','Vũ', 'Võ', 'Đặng', 'Bùi', 'Đỗ', 'Hồ', 'Ngô', 'Dương', 'Lý', 'Tống' ]);

    return [
        'name' => $lastName->random() . ' ' . $faker->middleName() . ' ' . $faker->firstName,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'phone' => $faker->unique()->phoneNumber,
        'address' => $faker->address,
        'remember_token' => str_random(10),
    ];
});
