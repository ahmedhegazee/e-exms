<?php

use App\Subject\Subject;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(\App\Subject\Subject::class,100)->create();
        $this->createGeneralSubjects(1,[1,6]);
        $this->createGeneralSubjects(2,[1,6]);
        $this->createGeneralSubjects(3,[2,3,4,5]);
        $this->createGeneralSubjects(4,[2,3,4,5]);



//        $faker = new Faker();
//        \App\Level::all()->each(function ($level) use ($faker) {
//            $level->departments->each(function ($dept) use ($faker, $level) {
//                for ($j = 1; $j < 3; $j++) {
//                    for ($i = 1; $i < 6; $i++) {
//
//                        $fake=$faker->numberBetween(1,100);
//
//                    }
//                }
//
//            });
//        });
    }

    public function createGeneralSubjects($level,$departments)
    {
        for($j=1;$j<3;$j++){
            for($i=1;$i<6;$i++){
                $subject=Subject::create([
                    'subject_name' => 'Subject ' .$i ,
                    'subject_code' => 'CS'.(rand(1,1000)*$i*$j*$level),
                    'level_id' => $level,
                    'term' => $j,
                    'professor_id' => 1,
                    'credit_hours' => 3
                ]);
                $subject->departments()->attach($departments);

            }
        }
    }
}
