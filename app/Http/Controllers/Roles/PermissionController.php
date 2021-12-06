<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class PermissionController extends Controller
{
    public function index(){
        
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        $permission = Permission::create(['name' => $request->name, 'description' => $request->description]);
        request()->session()->flash('message', "Permiso Creado");

        return Redirect::route('rolesandpermissions.index'); 
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        request()->session()->flash('message', "Permiso Eliminado");

        return Redirect::route('rolesandpermissions.index');
    }

    public function getPermissions(){

        $permissions = Permission::all();

        return response()->json($permissions);
    }
}
