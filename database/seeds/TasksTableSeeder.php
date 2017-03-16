<?php

use Illuminate\Database\Seeder;
use \App\Task;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $task = new Task([
            'name' => 'Kysely 1',
            'description' => 'Valitse opettajien nimet.',
            'solution' => 'SELECT opettaja FROM kurssit;',
            'type' => 'select',
            #'diagram' = '',
            'creator' => 1,
        ]);
        $task->save();

        $task = new Task([
            'name' => 'Kysely 2',
            'description' => 'Valitse opiskelijoiden nimet, joilla pääaineena on \'TKO\'.',
            'solution' => "SELECT nimi FROM opiskelijat WHERE p_aine = 'TKO';",
            'type' => 'select',
            #'diagram' = '',
            'creator' => 1,
        ]);
        $task->save();

        $task = new Task([
            'name' => 'Kysely 3',
            'description' => "Mitkä ovat 'Villen' suorittamien kurssien arvosanat?",
            'solution' => "SELECT s.arvosana FROM opiskelijat o, suoritukset s WHERE o.nro = s.op_nro AND o.nimi = 'Ville';",
            'type' => 'select',
            #'diagram' = '',
            'creator' => 1,
        ]);
        $task->save();

        $task = new Task([
            'name' => 'Kysely 4',
            'description' => "Lisää opiskelija nimeltä 'Matti' tietokantaan. Matin opiskelijanumero on 1234 ja pääaine VT.",
            'solution' => "INSERT INTO opiskelijat VALUES (1234, 'Matti', 'VT');",
            'type' => 'insert',
            #'diagram' = '',
            'creator' => 1,
        ]);
        $task->save();

        $task = new Task([
            'name' => 'Kysely 5',
            'description' => "Poista opiskelija, jonka numero on 1234.",
            'solution' => "DELETE FROM opiskelijat WHERE nro = 1234;",
            'type' => 'delete',
            #'diagram' = '',
            'creator' => 1,
        ]);
        $task->save();

    }
}
