<?php

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Department::create([
           'department_title'=>'General'
        ]);
        \App\Department::create([
           'department_title'=>'Software Engineering'
        ]);
        \App\Department::create([
            'department_title'=>'Computer Science'
        ]);
        \App\Department::create([
           'department_title'=>'Information Technology'
        ]);
        \App\Department::create([
            'department_title'=>'Information System'
        ]);
        \App\Department::create([
            'department_title'=>'Bio  informatics'
        ]);

    }
}
