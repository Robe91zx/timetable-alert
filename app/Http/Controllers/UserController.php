<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $table_Columns = User::USERS_COLUMNS;
        $selectOptions = User::USERS_OPTIONS;

        if(request()->has("name")){
            $name = request("name");
            $users = User::where('name','like','%'.$name.'%')->get();
        }
        //else{ $users = User::select('profile_photo_path','name','email')->get();}
        else{ $users = User::all();}
        
        return Inertia::render('Users/ShowUsers', ['users' => $users, 'table_Columns' => $table_Columns, 'selectOptions' => $selectOptions ]);
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return Inertia::render('Users/EditUserForm', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $member)
    {
        $member->delete();
        request()->session()->flash('message', "Usuario Eliminado");
        
        return Redirect::route('users.index');
    }

    public function getNonRoleUsers(){
        
        $users = User::doesntHave('roles')->get();
        
        return response()->json($users);
    }
}
