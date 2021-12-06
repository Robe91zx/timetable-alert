<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Http\Requests\StoreDepartment;
use App\Http\Requests\UpdateDepartment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Excel;
use App\Imports\DepartmentsImport;
use App\Exports\DepartmentsExport;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = Department::DEPARTMENTS_COLUMNS;
        $options = Department::DEPARTMENTS_OPTIONS;

        if(request()->has("name")){
            $name = request("name");
            $departments = Department::where('name','like','%'.$name.'%')->get();
        
        }else{ $departments = Department::all();}

        return Inertia::render('Departments/ShowDepartments',['departments' => $departments, 'columns' => $columns, 'options' => $options]);
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
    public function store(StoreDepartment $request)
    {
        Department::create($request->all());
        request()->session()->flash('flash.banner', "Recurso: {$request->name} Creado ");
        request()->session()->flash('flash.bannerStyle', 'success');    

        return Redirect::route('departments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        $columns = Department::CARREERS_COLUMNS;
        $CarreersOf = Department::with('carreers')->where('vcode','=',$department->vcode)->get();   

        return Inertia::render('Departments/Carreers/CarreersOfDepartments', [ 'CarreersOf' => $CarreersOf, 'columns' => $columns]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        return Inertia::render('Departments/EditDepartmentForm',['department' => $department]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDepartment $request, Department $department)
    {
        $department-> update($request->all());
        request()->session()->flash('flash.banner', "Recurso: {$department->name} Actualizado ");
        request()->session()->flash('flash.bannerStyle', 'success'); 

        return Redirect::route('departments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $department->delete();
        request()->session()->flash('flash.banner', "Recurso: {$department->name} Eliminado ");
        request()->session()->flash('flash.bannerStyle', 'success'); 

        return Redirect::route('departments.index');
    }

    public function getDepartments(){
        $departments = Department::all();

        return response()->json($departments);
    }

    public function import(Request $request)
    {   
        $path = $request->file('file');
        
        Excel::import(new DepartmentsImport, $path);
        request()->session()->flash('flash.banner', "Departamentos Cargados desde Excel ");
        request()->session()->flash('flash.bannerStyle', 'success'); 

        return Redirect::route('departments.index');
    }

    public function export()
    {
        request()->session()->flash('flash.banner', "Departamentos Respaldados a Excel ");
        request()->session()->flash('flash.bannerStyle', 'success'); 

        return Excel::download(new DepartmentsExport,'departments.xlsx');
    }
}
