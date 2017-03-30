<?php

namespace App\Http\Controllers;

use App\Http\Requests\SessionTasksFormRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\TaskAttempt;
use App\SessionTask;
use Carbon\Carbon;
use App\Tasklist;
use App\Session;
use App\Task;
use DB;

class SessionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasklists = Tasklist::all()->sortBy('id');

        return view('home', compact('tasklists'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function startSession($tasklist_id)
    {
        $session = Session::create([
            'start_time' => Carbon::now(),
            'user_id' => auth()->user()->id,
            'tasklist_id' => $tasklist_id,
        ]);

        $task_id = $session->tasklist->tasks()->first()->id;

        return redirect("/session/{$session->id}/{$task_id}");
    }


    public function showTask($session_id, $task_id)
    {
        extract($this->getSessionInfo($session_id, $task_id));   

        $errors = \Illuminate\Support\Facades\Session::get('errors');
        if (!isset($errors)) {
            
            DB::beginTransaction();

            $taskAttempt = TaskAttempt::create([
                'count' => (($attempts < 3) ? ($attempts + 1) : 1),
                'start_time' => Carbon::now(),
                'session_id' => $session->id,
                'task_id' => $task_id,
            ]);

            if ($attempts == 0) {
                SessionTask::create([
                    'start_time' => Carbon::now(),
                    'session_id' => $session->id,
                    'task_id' => $task_id,
                ]);
            }

            DB::commit();
        }

        $currentTaskNo  = SessionTask::where('session_id', $session_id)->count();

        return view('session.task', compact('session', 'task', 'taskCount', 'currentTaskNo', 'taskAttempt'));
    }


    public function summary($session_id) 
    {
        $summary  = DB::select("SELECT tasks.name AS tehtävä, count AS yritys, 
                                    (end_time - start_time) AS aika, result AS tulos, 
                                    answer AS vastaus, tasks.solution AS ratkaisu 
                                FROM task_attempts INNER JOIN tasks ON task_id = tasks.id
                                WHERE session_id = {$session_id}
                                ORDER BY (tasks.id, count);");

        $session_time = DB::select("SELECT (end_time - start_time) AS time
                                    FROM sessions
                                    WHERE id = {$session_id};");

        $session_time = $session_time[0]->time;

        return view('session.summary', compact('summary', 'session_time'));
    }


    public function feedback($session_id, $task_id)
    {
        extract($this->getSessionInfo($session_id, $task_id));        

        try {
            $result = $this->selectFromConn2($taskAttempt->answer, 'pgsql2');
            $queryExc = '';       
        } catch (QueryException $e) {
            $result = [];
            $queryExc = $e->getMessage();
        }
        $exampleResult = $this->selectFromConn2($task->solution, 'pgsql2');
        
        if (!$taskAttempt->result && $taskAttempt->count < 3) {
            $nextTaskId = $task->id;
        } else if (SessionTask::where('session_id', $session_id)->count() < $session->tasklist->tasks->count()) {
            $nextTaskId = $session->tasklist->tasks()->skip($currentTaskNo)->first()->id;
        } else {
            $nextTaskId = 0;
        }

        return view('session.feedback', compact('session', 'task', 'taskCount', 
                                                'currentTaskNo', 'nextTaskId', 'taskAttempt', 
                                                'result', 'exampleResult', 'queryExc'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function saveAttempt(SessionTasksFormRequest $request, $session_id, $task_id)
    {
        extract($this->getSessionInfo($session_id, $task_id));

        if (isset($taskAttempt->result)) {
            return redirect("/session/{$session_id}/{$taskAttempt->task_id}/feedback")
                   ->with('status', 'Virheellinen yritys, selaimella peruuttaminen ei sallittua!');
        }

        try {
            $result = $this->selectFromConn2($request->userQuery, 'pgsql2');
        } catch (QueryException $e) {
            $result = [];
        }

        $exampleResult = $this->selectFromConn2($task->solution, 'pgsql2');
        
        DB::beginTransaction();

        $taskAttempt->end_time = Carbon::now();
        $taskAttempt->answer = $request->userQuery;
        $taskAttempt->result = ($result == $exampleResult ? true : false);
        $taskAttempt->save();

        if ($taskAttempt->result || $taskAttempt->count == 3) {
            $sessionTask->end_time = Carbon::now();
            $sessionTask->save();

            if (SessionTask::where('session_id', $session_id)->count() == $session->tasklist->tasks->count()) {
                $session->end_time = Carbon::now();
                $session->save();
            }
        }

        DB::commit();

        return redirect("/session/{$session_id}/{$taskAttempt->task_id}/feedback");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    private function getSessionInfo($session_id, $task_id) 
    {
        $task           = Task::find($task_id);
        $session        = Session::find($session_id);
        $taskCount      = Session::find($session_id)->tasklist->tasks->count();
        $currentTaskNo  = SessionTask::where('session_id', $session_id)->count();
        $sessionTask    = SessionTask::where([['task_id', $task_id], ['session_id', $session_id]])->first();
        $attempts       = TaskAttempt::where([['session_id', $session_id], ['task_id', $task_id]])->get()->count();
        $taskAttempt    = TaskAttempt::where([['session_id', $session_id], ['task_id', $task_id]])
                                     ->orderBy('count', 'desc')
                                     ->first();

        return compact('session', 'task', 'sessionTask', 'taskAttempt', 'taskCount', 'currentTaskNo', 'attempts');
    }


    private function selectFromConn2($query, $conn) 
    {
        $queryParts = explode(' ', strtolower($query));
        $result = [];

        DB::connection($conn)->beginTransaction();

        try {
            if ($queryParts[0] == 'select') {
                $result = DB::connection($conn)->select($query);

            } else if ($queryParts[0] == 'insert' && count($queryParts) > 2) {
                DB::connection($conn)->select($query);
                $result = DB::connection($conn)->select("select * from " . $queryParts[2] . ";");

            } else if ($queryParts[0] == 'delete' && count($queryParts) > 2) {
                // Vaihdetaan kyselyssä olevan taulun nimen perään 2 (eli 'opiskelijat2')
                // Tässä APUtaulussa on poistettava tieto olemassa toisin kuin "varsinaisessa" taulussa
                $queryParts[2] = $queryParts[2] . "2";
                $query = implode(' ', $queryParts);

                DB::connection($conn)->select($query);
                $result = DB::connection($conn)->select("select * from " . $queryParts[2] . ";");

            } else if ($queryParts[0] == 'update') {
                dd('Update ei toiminnassa!');

            } else {
                $result = DB::connection($conn)->select($query);
            }

        } catch (QueryException $e) {
            DB::connection($conn)->rollBack();
            throw $e;
        }

        DB::connection($conn)->rollBack();
        return $result;
    }
}
