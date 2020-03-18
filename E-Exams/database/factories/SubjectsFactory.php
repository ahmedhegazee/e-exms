<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Department;
use App\Level;
use App\Subject\Subject;
use Faker\Generator as Faker;

$factory->define(Subject::class, function (Faker $faker) {
    return [
        'subject_name' => 'Subject 1' ,
        'subject_code' => 'CS'.$faker->unique()->numberBetween(1,1000),
        'level_id' => $faker->randomElement(Level::all())->id,
        'department_id' => $faker->randomElement(Department::all())->id,
        'term' => $faker->randomElement([1,2]),
        'professor_id' => 1,
        'credit_hours' => 3
    ];
});
