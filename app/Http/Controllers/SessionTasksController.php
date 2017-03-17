<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests;
use App\TaskAttempt;
use App\SessionTask;
use App\Session;
use App\Task;
use DB;

class SessionTasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($session_id, $task_id)
    {
        $session = Session::find($session_id);
        $task = Task::find($task_id);
        $taskCount = Session::find($session_id)->tasklist->tasks->count();
        $currentTaskNo = SessionTask::where('session_id', $session_id)->count();
        $taskAttempt = TaskAttempt::where([['session_id', $session_id], ['task_id', $task_id]])
            ->orderBy('count', 'desc')
            ->first();

        return view('session.task', compact('session', 'task', 'taskCount', 'currentTaskNo', 'taskAttempt'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $session_id, $task_id)
    {
        $session = Session::find($session_id);
        $sessionTotalTaskCount = Session::find($session_id)->tasklist->tasks->count();
        $currentTaskNo = SessionTask::where('session_id', $session_id)->count();

        $taskAttempt = TaskAttempt::where([['session_id', $session_id], ['task_id', $task_id]])
            ->orderBy('count', 'desc')
            ->first();

        $this->validate($request, [
            'userQuery' => 'required|start_with_sql_command|even_brackets|semicolon_at_end|semicolon_max:1'
        ]);

        DB::connection('pgsql2')->beginTransaction();
        $result = DB::connection('pgsql2')->select($request->userQuery);
        DB::connection('pgsql2')->rollBack();
        
        DB::connection('pgsql2')->beginTransaction();
        $exampleResult = DB::connection('pgsql2')->select( Task::find($task_id)->solution );
        DB::connection('pgsql2')->rollBack();

        $taskAttempt->end_time = \Carbon\Carbon::now();
        $taskAttempt->answer = $request->userQuery;

        if ($result != $exampleResult) {

            DB::beginTransaction();
            $taskAttempt->result = false;
            $taskAttempt->save();

            // Jos alle kolme yritystä
            if ($taskAttempt->count < 3) {
                $taskAttempt = TaskAttempt::create([
                    'count' => $taskAttempt->count + 1,
                    'start_time' => \Carbon\Carbon::now(),
                    'session_id' => $session->id,
                    'task_id' => $task_id,
                ]);
                DB::commit();

                return redirect("/session/{$session_id}/{$taskAttempt->task_id}");
            }

            // Jos kaikki tehtävät tehtynä
            if ($sessionTotalTaskCount == $currentTaskNo) {
                DB::commit();
                return view('welcome')->with('status', 'Valmista tuli!');
            }

            // Jos jatketaan seuraavaan tehtävään
            $taskAttempt = TaskAttempt::create([
                'count' => 1,
                'start_time' => \Carbon\Carbon::now(),
                'session_id' => $session->id,
                'task_id' => $session->tasklist->tasks()->skip( SessionTask::where('session_id', $session->id)->count() )->first()->id,
            ]);

            $sessionTask = SessionTask::create([
                'start_time' => \Carbon\Carbon::now(),
                'session_id' => $session->id,
                'task_id' => $taskAttempt->task_id,
            ]);

            DB::commit();

            return redirect("/session/{$session_id}/{$taskAttempt->task_id}");
            #return back()->with('status', 'Yritykset käytetty, siirto seuraavaan tehtävään!');
        }
        else {
            dd('Onnistui');
            DB::commit();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
