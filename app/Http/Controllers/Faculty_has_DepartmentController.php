<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Faculty;
use App\Models\Faculty_hasDepartment;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Excel;
use App\Imports\Faculty_hasDepartmentImport;
use App\Exports\Faculty_hasDepartmentExport;
use App\Http\Requests\StoreFaculty_has_Department;

class Faculty_has_DepartmentController extends Controller
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
        $faculties = Faculty::select('vcode','name')->get();
        $departments = Department::select('vcode','name')->get();

        return response()->json([$faculties, $departments]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Faculty_hasDepartment::create([
            'faculty_vcode' => $request->faculty_id['vcode'],
            'department_vcode' => $request->department_id['vcode']
        ]);

        request()->session()->flash('flash.banner', "Departamento {$request->department_id['name']} asignado a Facultad {$request->faculty_id['name']}");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('faculties.index');
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
        dd($facultiesanddepartment);
        $facultiesanddepartment->delete();
        request()->session()->flash('message', "Relacion Eliminada");
        return Redirect::route('faculties.index');
    }

    public function import(Request $request)
    {
        $path = $request->file('file');
        
        Excel::import(new Faculty_hasDepartmentImport, $path);
        request()->session()->flash('flash.banner', "Relacion Facultad - Carrera Cargadas desde Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('faculties.index');
    }

    public function export()
    {
        request()->session()->flash('flash.banner', "Relacion Facultad - Carrera Respaldadas en Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Excel::download(new Faculty_hasDepartmentExport,'facultiesandcarreers.xlsx');      
    }
}
