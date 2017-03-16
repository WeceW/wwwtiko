<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\UsersFormRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\User;
use DB;

class UsersController extends Controller
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
        $users = User::all()->sortBy('name');

        return view('users.index', compact('users'));
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
    public function store(Request $request)
    {
        //
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
        $user = User::find($id);
        $allRoles = \App\Role::all();

        return view('users.edit', compact('user', 'allRoles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersFormRequest $request, $id)
    {
        $user = User::find($id);

        /* Tähän tarkistukseen pitäisi saada myös roolit lisättyä, 
           mutta ehkä tällaisen tarkastelun voi jättää tekemättäkin
           kun ei varsinaista ongelmaakaan seuraa...

        if($request->name == $user->name &&
           $request->student_nro == $user->student_nro &&
           $request->major == $user->major &&
        {
            return back()->with('status', 'Ei mitään muutettavaa');
        }
        */ 

        $user->name = $request->name;
        $user->student_nro = $request->student_nro;
        $user->major = $request->major;

        DB::beginTransaction();
        $user->save();

        $user->roles()->detach();
        if (isset($request->roles)) {
            foreach ($request->roles as $role) {
                if (! $user->roles->pluck('id')->contains($role))
                    $user->roles()->attach($role);
            }
        }
        DB::commit();

        return redirect('users')->with('status', "Käyttäjän '{$user->name}' tiedot päivitetty.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $name = $user->name;
        $user->delete();

        return redirect('/users')->with('status', "Käyttäjän '{$name}' tili on nyt poistettu.");
    }
}
