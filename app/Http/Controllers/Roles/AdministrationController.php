<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Administration;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class AdministrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tableColumns = Administration::ADMINISTRATION_COLUMNS;
        $selectedOptions = Administration::ADMINISTRATION_OPTIONS;

        if(request()->has("name")){
            $name = request("name");
            $roles = Role::where('name','like','%'.$name.'%')->get();
        }else{$roles = Role::with('permissions')->get();} 

        return Inertia::render('RolesAdministration/ShowAdministration', ['roles' => $roles, 'tableColumns' => $tableColumns, 'selectedOptions' => $selectedOptions]);
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
        //dd($request);
        $request->validate([
            'name' => 'required',
        ]);
    
        $role = Role::create($request->all());
        $role->permissions()->sync($request->cpermissions);

        request()->session()->flash('message', "Rol Asignado");
        return Redirect::route('rolesandpermissions.index');
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

    public function getRolePermissions(Role $role){
           
        
       $permissions = Permission::all();  

       return $permissions; 
   }
}
