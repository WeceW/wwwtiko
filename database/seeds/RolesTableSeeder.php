<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;


class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $roleAdmin      = new Role(['name' => 'admin',   'label' => 'Admin']);
        $roleTeacher    = new Role(['name' => 'teacher', 'label' => 'Teacher']);
        $roleUser       = new Role(['name' => 'user',    'label' => 'Basic user']);

        $roleAdmin->save();
        $roleTeacher->save();
        $roleUser->save(); 
        
        $permUsers      = new Permission(['name' => 'manage-users',     'label' => 'Can manage users']);
        $permTasks      = new Permission(['name' => 'manage-tasks',     'label' => 'Can manage tasks']);
        $permComments   = new Permission(['name' => 'manage-comments',  'label' => 'Can manage comments']);

        $permUsers->save(); 
        $permTasks->save(); 
        $permComments->save(); 

        $roleAdmin->permissions()->attach([$permTasks->id, $permUsers->id, $permComments->id]);
        $roleTeacher->permissions()->attach([$permTasks->id, $permComments->id]);

    }
}
