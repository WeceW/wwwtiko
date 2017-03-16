<?php

namespace App\Http\Controllers;

#use Illuminate\Http\Request;
use App\Http\Requests\TasklistsFormRequest;
use App\Http\Requests;
use App\Tasklist;
use App\Task;
use DB;

class TasklistsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasklists = Tasklist::all()->sortBy('id');

        return view('tasks.tasklist', compact('tasklists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tasks = Task::all()->sortBy('id');

        return view('tasks.tasklist_create', compact ('tasks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TasklistsFormRequest $request)
    {
        DB::beginTransaction();

        $tasklist = new Tasklist([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        $tasklist->creator = auth()->user()->id;
        $tasklist->save();

        if (isset($request->tasks))
            $tasklist->tasks()->attach($request->tasks);

        DB::commit();

        $tasklists = Tasklist::all()->sortBy('id');
        return view('tasks.tasklist', compact('tasklists'));
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
        $tasklist = Tasklist::find($id);
        $tasks = Task::all()->sortBy('id');
        return view('tasks.tasklist_edit', compact('tasklist', 'tasks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TasklistsFormRequest $request, $id)
    {
        $tasklist = Tasklist::find($id);

        $tasklist->name = $request->name;
        $tasklist->description = $request->description;

        DB::beginTransaction();

        $tasklist->save();

        $tasklist->tasks()->detach();
        if (isset($request->tasks)) {
            $tasklist->tasks()->attach($request->tasks);
        }

        DB::commit();

        return redirect('/tasklists')->with('status', "Tehtävälistan nro {$tasklist->id} päivitys onnistui!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tasklist = Tasklist::find($id);
        $tasklist->delete();

        return back()->with('status', "Tehtävälista nro {$tasklist->id} poistettu!");
    }
}
