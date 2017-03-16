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

        /* 
         * Roles
         */
        DB::table('roles')->insert([ 
            'name' => 'admin',
            'label' => 'Admin',
        ]);

        DB::table('roles')->insert([ 
            'name' => 'teacher',
            'label' => 'Teacher',
        ]);

        DB::table('roles')->insert([ 
            'name' => 'user',
            'label' => 'Basic user',
        ]);


        /* 
         * Permissions
         */
        DB::table('permissions')->insert([ 
            'name' => 'manage-tasks',
            'label' => 'Can manage tasks',
        ]);

        DB::table('permissions')->insert([ 
            'name' => 'manage-users',
            'label' => 'Can manage users',
        ]);

        /*
         * Pivot tables
         */

        // Admin can manage tasks
        DB::table('permission_role')->insert([ 
            'permission_id' => 1,
            'role_id' => 1,
        ]);

        // Admin can manage users
        DB::table('permission_role')->insert([ 
            'permission_id' => 2,
            'role_id' => 1,
        ]);

        // Teacher can manage tasks
        DB::table('permission_role')->insert([ 
            'permission_id' => 1,
            'role_id' => 2,
        ]);
    }
}
