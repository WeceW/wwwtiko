<?php

namespace App\Http\Controllers;

use App\Http\Requests\TasksFormRequest;
use App\Task;
#use Illuminate\Http\Request;
use App\Http\Requests;
use DB;

class TasksController extends Controller
{
    public function __construct()
    {
        $this->middleware('teacher');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all()->sortBy('id');

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TasksFormRequest $request)
    {
        DB::beginTransaction();

        $task = Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'solution' => $request->solution,
            'type' => $request->type,
            'diagram' => $request->diagram,
        ]);

        $task->creator = auth()->user()->id;
        $task->save();

        DB::commit();

        return redirect('/tasks')->with('status', "Tehtävä nro {$task->id} lisätty onnistuneesti.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TasksFormRequest $request, $id)
    {
        $task = Task::find($id);

        if($request->name == $task->name
           && $request->description == $task->description
           && $request->solution == $task->solution
           && $request->type == $task->type
           && $request->diagram == $task->diagram) 
        {
            return back()->with('status', 'Ei mitään muutettavaa.');
        }

        $task->name = $request->name;
        $task->description = $request->description;
        $task->solution = $request->solution;
        $task->type = $request->type;
        $task->diagram = $request->diagram;
        $task->save();

        return redirect('/tasks')->with('status', "Tehtävän nro {$task->id} päivitys onnistui.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();

        return back()->with('status', "Tehtävä nro {$task->id} poistettu.");
    }
}
