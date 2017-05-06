<?php

use Illuminate\Database\Seeder;
use App\TaskAttempt;
use App\SessionTask;
use Carbon\Carbon;
use App\Tasklist;
use App\Session;
use App\Task;

class SessionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        # Luodaan silmukan avulla x-määrä sessioita tietokantaan
        # (Tämä tietysti vain esimerkkidatan vuoksi, eli varsinaisessa sovelluksessa
        # ei sessioita tietysti valmiiksi luotaisi tilastoja vääristämään)
        for ($i = 0; $i < 100; $i++) {

            $date = Carbon::now()->subDays(mt_rand(1,31));

            $session = Session::create([
                'start_time' => $date,
                'user_id' => mt_rand(1,3),
                'tasklist_id' => mt_rand(1,2),
            ]);

            $task_id = $session->tasklist->tasks()->first()->id;

            $done = false;
            while (!$done) {

                $attempts = TaskAttempt::where([['session_id', $session->id], ['task_id', $task_id]])->get()->count();

                $taskAttempt = TaskAttempt::create([
                    'count' => (($attempts < 3) ? ($attempts + 1) : 1),
                    'start_time' => $date,
                    'session_id' => $session->id,
                    'task_id' => $task_id,
                ]);

                if ($attempts == 0) {
                    $sessionTask = SessionTask::create([
                        'start_time' => $date,
                        'session_id' => $session->id,
                        'task_id' => $task_id,
                    ]);
                }

                $date = $date->addSeconds(mt_rand(15,120));

                # taskAttempt täytyy jostain syystä hakea uudelleen eikä onnistu id:n avulla joten mennään vähän mutkan kautta:
                $taskAttempt = TaskAttempt::where([['session_id', $session->id], ['task_id', $task_id], ['count', $attempts+1]])->first();

                $taskAttempt->end_time = $date;
                $taskAttempt->answer = 'Esimerkkidataa';
                $taskAttempt->result = (bool)mt_rand(0,1);
                $taskAttempt->save();

                if ($taskAttempt->result || $taskAttempt->count == 3) {
                    $sessionTask = SessionTask::where([['session_id', $session->id], ['task_id', $task_id]])->first();
                    $sessionTask->end_time = $date;
                    $sessionTask->save();

                    if (SessionTask::where('session_id', $session->id)->count() == $session->tasklist->tasks->count()) {
                        $session->end_time = $date;
                        $session->save();
                        $done = true;
                    }
                }

                if (!$taskAttempt->result && $taskAttempt->count < 3) {
                    $task_id = $task_id;
                } else if (SessionTask::where('session_id', $session->id)->count() < $session->tasklist->tasks->count()) {
                    $currentTaskNo  = SessionTask::where('session_id', $session->id)->count();
                    $task_id = $session->tasklist->tasks()->skip($currentTaskNo)->first()->id;
                } else {
                    #$task_id = 0;
                    $done = true;
                }
            
            } // endwhile

        } //endfor

    }
}
