<?php

namespace App\Http\Controllers;

use App\Models\FacultyDepartment;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDepartmentsOfFaculty;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\Department;
use App\Models\Faculty;
use Excel;
use App\Imports\FacultyandDepartmentImport;
use App\Exports\FacultyandDepartmentExport;

class FacultyDepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
    public function store(StoreDepartmentsOfFaculty $request)
    { 
        FacultyDepartment::create([
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
     * @param  \App\Models\FacultyDepartment  $facultyDepartment
     * @return \Illuminate\Http\Response
     */
    public function show(FacultyDepartment $facultyDepartment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FacultyDepartment  $facultyDepartment
     * @return \Illuminate\Http\Response
     */
    public function edit(FacultyDepartment $facultyDepartment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FacultyDepartment  $facultyDepartment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FacultyDepartment $facultyDepartment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FacultyDepartment  $facultyDepartment
     * @return \Illuminate\Http\Response
     */
    public function destroy(FacultyDepartment $facultiesanddepartment)
    {   
        dd($facultiesanddepartment);
        $facultiesanddepartment->delete();
        request()->session()->flash('message', "Relacion Eliminada");
        return Redirect::route('faculties.index');
    }

    public function import(Request $request)
    {
        $path = $request->file('file');
        
        Excel::import(new FacultyandDepartmentImport, $path);
        request()->session()->flash('flash.banner', "Relacion Facultad - Departamentos Cargadas desde Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('faculties.index');
    }

    public function export()
    {
        request()->session()->flash('flash.banner', "Relacion Facultad - Departamentos Respaldadas en Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Excel::download(new FacultyandDepartmentExport,'facultiesanddepartments.xlsx');
    }
}
