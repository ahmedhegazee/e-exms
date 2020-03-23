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
        $prof = \App\User::create([
            'full_name' => 'prof ahmed',
            'email' => 'prof_ahmed@email.com',
            'password' => bcrypt('password'),
            'email_verified_at' => date('Y-m-d g:i:s'),
            'approved' => 1
        ]);
        $prof->professor()->create([
            'department_id' => 2
        ]);
        echo 'prof ' . $prof->createToken('auth_token')->accessToken . PHP_EOL;
        $prof->roles()->attach([2, 3]);
        $user = \App\User::create([
            'full_name' => 'ahmed hegazy',
            'email' => 'hegazy@email.com',
            'password' => bcrypt('password'),
            'email_verified_at' => date('Y-m-d g:i:s'),
            'approved' => 1
        ]);
        $user->roles()->attach(1);
        $student = $user->student()->create([
            'academic_id' => '0123456789012345'
        ]);

        $student->registrations()->create([
            'level_id' => 1,
            'department_id' => 1,
            'term' => 1
        ]);
        echo ' student ' . $user->createToken('auth_token')->accessToken . PHP_EOL;
    }
}
