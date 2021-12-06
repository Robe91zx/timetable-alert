<?php

namespace App\Http\Controllers;

use App\Models\DepartmentCarreer;
use App\Models\Department;
use App\Models\Carreer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Excel;
use App\Imports\DepartmentandCarreerImport;
use App\Exports\DepartmentandCarreerExport;
use App\Http\Requests\StoreCarreersOfDepartment;
use App\Http\Requests\UpdateCarreersOfDepartment;

class DepartmentCarreersController extends Controller
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
    public function store(StoreCarreersOfDepartment $request)
    {
        DepartmentCarreer::create([
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
     * @param  \App\Models\DepartmentCarreer  $departmentCarreer
     * @return \Illuminate\Http\Response
     */
    public function show(DepartmentCarreer $departmentCarreer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DepartmentCarreer  $departmentCarreer
     * @return \Illuminate\Http\Response
     */
    public function edit(DepartmentCarreer $departmentCarreer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DepartmentCarreer  $departmentCarreer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DepartmentCarreer $departmentCarreer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DepartmentCarreer  $departmentCarreer
     * @return \Illuminate\Http\Response
     */
    public function destroy(DepartmentCarreer $departmentCarreer)
    {
        //
    }

    public function import(Request $request)
    {
        $path = $request->file('file');
        
        Excel::import(new DepartmentandCarreerImport, $path);
        request()->session()->flash('flash.banner', "Relacion Facultad - Carrera Cargadas desde Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('departments.index');
    }

    public function export()
    {
        request()->session()->flash('flash.banner', "Relacion Facultad - Carrera Respaldadas en Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Excel::download(new DepartmentandCarreerExport,'facultiesandcarreers.xlsx');      
    }
}
