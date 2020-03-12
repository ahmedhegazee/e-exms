<?php

use App\StudyingPlan;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prof=\App\User::create([
            'full_name' => 'prof ahmed',
            'email' => 'prof_ahmed@email.com',
            'password' => bcrypt('password'),
            'user_type'=>1 // 1 for student , 2 for professor
        ]);
        $prof->professor()->create([
            'department_id'=>2
        ]);
        $user=\App\User::create([
            'full_name' => 'ahmed hegazy',
            'email' => 'hegazy@email.com',
            'password' => bcrypt('password'),
            'user_type'=>2 // 1 for student , 2 for professor
        ]);
        $student=$user->student()->create([
            'academic_id'=>'0123456789012345'
        ]);
        $currentTerm=StudyingPlan::current(1)->get()->first()->term;
        $currentYear=StudyingPlan::current(1)->get()->first()->year;
        $student->registrations()->create([
            'level_id'=>1,
            'department_id'=>1,
            'studying_term_id'=>$currentTerm->id,
            'studying_year_id'=>$currentYear->id
        ]);
    }
}
