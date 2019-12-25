<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Question::class, function (Faker $faker) {
    return [
        'textOfQuestion' => $faker->text(50),
        'answerA' => $faker->text(10),
        'answerB' => $faker->text(10),
        'answerC' => $faker->text(10),
        'answerD' => $faker->text(10),
        'correctAnswer' => $faker->numberBetween(0, 3),
        'category' => $faker->randomElement($array = array ('Animals', 'History', 'Geography', 'Chemistry', 'Art'))
    ];
});
