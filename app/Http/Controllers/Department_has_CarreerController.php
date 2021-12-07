<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Carreer;
use App\Models\Department_hasCarreer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Excel;
use App\Imports\Department_hasCarreerImport;
use App\Exports\Department_hasCarreerExport;
use App\Http\Requests\StoreDepartment_hasCarreer;
use App\Http\Requests\UpdateDepartment_hasCarreer;

class Department_has_CarreerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::select('vcode','name')->get();
        $carreers = Carreer::select('vcode','name')->get();

        return response()->json([$departments, $carreers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepartment_hasCarreer $request)
    {
        Department_hasCarreer::create([
            'department_vcode' => $request->department_id['vcode'],
            'carreer_vcode' => $request->carreer_id['vcode']
        ]);

        request()->session()->flash('flash.banner', "Carrera {$request->carreer_id['name']} asignado al Departamento de {$request->department_id['name']}");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('departments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department_hasCarreer  $department_hasCarreer
     * @return \Illuminate\Http\Response
     */
    public function show(Department_hasCarreer $department_hasCarreer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department_hasCarreer  $department_hasCarreer
     * @return \Illuminate\Http\Response
     */
    public function edit(Department_hasCarreer $department_hasCarreer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department_hasCarreer  $department_hasCarreer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department_hasCarreer $department_hasCarreer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department_hasCarreer  $department_hasCarreer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department_hasCarreer $department_hasCarreer)
    {
        //
    }

    public function import(Request $request)
    {
        $path = $request->file('file');
        
        Excel::import(new Department_hasCarreerImport, $path);
        request()->session()->flash('flash.banner', "Relacion Facultad - Carrera Cargadas desde Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('departments.index');
    }

    public function export()
    {
        request()->session()->flash('flash.banner', "Relacion Facultad - Carrera Respaldadas en Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Excel::download(new Department_hasCarreerExport,'facultiesandcarreers.xlsx');      
    }
}
