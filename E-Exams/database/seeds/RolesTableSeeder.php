<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Role::create([
            'role_title'=>'Student'
        ]);
        \App\Role::create([
            'role_title'=>'Professor'
        ]);
        \App\Role::create([
            'role_title'=>'Admin'
        ]);
    }
}
