<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Question::class, function (Faker $faker) {
    $categories = App\Category::pluck('id')->toArray();
    return [
        'text' => $faker->text(50),
        'language' => $faker->randomElement(array('en', 'pl')),
        'category' => $faker->randomElement($categories),
        'added_by_user' => function () {
            return factory(App\User::class)->create()->id;
        }
    ];
});

$factory->afterCreating(App\Question::class, function ($question, $faker) {
    $id = $question->id;

    $question->answers()->createMany([
    [
        'text' => $faker->text(20),
        'isCorrect' => 0,
        'question_id' => $id
    ],
    [
        'text' => $faker->text(20),
        'isCorrect' => 0,
        'question_id' => $id
    ],
    [
        'text' => $faker->text(20),
        'isCorrect' => 0,
        'question_id' => $id
    ],
    [
        'text' => $faker->text(20),
        'isCorrect' => 1,
        'question_id' => $id
    ]
    ]);
});
