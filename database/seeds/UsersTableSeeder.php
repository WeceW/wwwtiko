<?php

use Illuminate\Database\Seeder;
use \App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User([
            'name' => 'Admin',
            'student_nro' => 0,
            'major' => '',
            'password' => bcrypt('admin'),
        ]);
        $admin->save();
        $admin->roles()->attach(\App\Role::where('name', 'admin')->get()->first()->id);
        $admin->roles()->attach(\App\Role::where('name', 'teacher')->get()->first()->id);
        $admin->roles()->attach(\App\Role::where('name', 'user')->get()->first()->id);
        
        $user = new User([
            'name' => 'Ope',
            'student_nro' => 1111,
            'major' => 'TKT',
            'password' => bcrypt('salasana'),
        ]);
        $user->save();
        $user->roles()->attach(\App\Role::where('name', 'teacher')->get()->first()->id);

        $user = new User([
            'name' => 'Opiskelija',
            'student_nro' => 1234,
            'major' => 'TKT',
            'password' => bcrypt('salasana'),
        ]);
        $user->save();
        $user->roles()->attach(\App\Role::where('name', 'user')->get()->first()->id);

    }
}
