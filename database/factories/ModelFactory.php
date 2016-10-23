<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'id'=>$faker->numberBetween(0,99999999),
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'enabled'=>true,
        'remember_token' => str_random(10),
    ];
});


$factory->define(\App\Gamemodes::class,function(Faker\Generator $faker){
    return [
        'name'=>$faker->unique()->name
    ] ;
});

$factory->define(\App\Tanks::class,function(Faker\Generator $faker){
    return [
        'tankname'=>$faker->unique()->name
    ] ;
});


$factory->define(\App\Proofs::class,function(Faker\Generator $faker)use($factory){
    return [
        'id'=>$faker->unique()->numberBetween(0,100000),
        'approver_id'=>$faker->numberBetween(1,100000),
        'approved'=>$faker->boolean(),
        'decided'=>$faker->boolean(),
        'created_at'=>$faker->date(),
        'updated_at'=>$faker->date()
    ] ;
});


$factory->define(\App\Records::class,function(Faker\Generator $faker){
    return [
        'id'=>$faker->unique()->numberBetween(0,100000),
        'name'=>$faker->name(),
        'score'=>$faker->numberBetween(0,99999999),
        'tank_id'=>$faker->randomDigit,
        'gamemode_id'=>$faker->randomDigit,
        'ip_address'=>$faker->ipv6,
        'created_at'=>$faker->date(),
        'updated_at'=>$faker->date()
    ] ;
});


$factory->define(\App\Proofslink::class,function(Faker\Generator $faker)use($factory){
    return [
        'id'=>$faker->unique()->numberBetween(0,100000),
        'proof_id'=>$faker->numberBetween(1,100000),
        'proof_link'=>$faker->imageUrl(),
    ] ;
});