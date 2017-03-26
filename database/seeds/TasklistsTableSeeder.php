<?php

use Illuminate\Database\Seeder;
use App\Tasklist;

class TasklistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tasklist = new Tasklist([
            'name' => 'Kyselysarja 1',
            'description' => 'Sarja sisältää tehtävät 1-3',
            'creator' => 1,
        ]);
        $tasklist->save();
        $tasklist->tasks()->attach([1,2,3]);

        for ($i = 0; $i < rand(0,5); $i++) {
            $tasklist->comments()->save( factory('App\Comment', 1)->create() );
        }

        $tasklist = new Tasklist([
            'name' => 'Kyselysarja 2',
            'description' => 'Sarja sisältää tehtävät 1, 4 ja 5',
            'creator' => 1,
        ]);
        $tasklist->save();
        $tasklist->tasks()->attach([1,4,5]);

        for ($i = 0; $i < rand(0,5); $i++) {
            $tasklist->comments()->save( factory('App\Comment', 1)->create() );
        }
    }
}
