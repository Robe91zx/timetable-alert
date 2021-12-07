<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Department;
use App\Models\College;
use App\Models\Faculty_hasDepartment;
use App\Models\Faculty_hasCarreer;
use App\Models\Faculty_hasSubject;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFaculty;
use App\Http\Requests\UpdateFaculty;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Excel;
use App\Imports\FacultiesImport;
use App\Exports\FacultiesExport;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = Faculty::FACULTY_COLUMNS;
        $options = Faculty::FACULTY_OPTIONS;

        if(request()->has("name")){
            $name = request("name");
            $faculties = Faculty::where('name','like','%'.$name.'%')->get();
        
        }else{ $faculties = Faculty::all();}

        return Inertia::render('Faculties/ShowFaculties', ['faculties' => $faculties, 'columns' => $columns, 'options' => $options]);
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
    public function store(StoreFaculty $request)
    {
        Faculty::create($request->all());

        request()->session()->flash('flash.banner', "Facultad {$request->name} Creada ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('faculties.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    
     public function show(Faculty $faculty)
    {  
       //
    }

    public function showDepartmentsandColleges(Faculty $faculty)
    {  
        $columns = Faculty_hasDepartment::TABLE_COLUMNS;                                 
        $AllOf = Faculty::with(['departments','colleges'])->where('vcode','=',$faculty->vcode)->get();

        return Inertia::render('Faculties/Departments/Departments_Colleges_OfFaculty', ['DepartmentsOf'=> $AllOf, 'columns'=> $columns]);
    }

    public function showCarreers(Faculty $faculty)
    {  
        $columns = Faculty_hasCarreer::FACULTY_CARREERS_COLUMNS;                                 
        $AllOf = Faculty::with('carreers')->where('vcode','=',$faculty->vcode)->get();

        return Inertia::render('Faculties/Carreers/CarreersOfFaculty', ['CarreersOf'=> $AllOf, 'columns'=> $columns]);
    }

    public function showSubjects(Faculty $faculty)
    {  
        $columns = Faculty_hasSubject::FACULTY_SUBJECTS_COLUMNS;                                 
        $AllOf = Faculty::with('subjects')->where('vcode','=',$faculty->vcode)->get();

        return Inertia::render('Faculties/Subjects/SubjectsOfFaculty', ['SubjectsOf'=> $AllOf, 'columns'=> $columns]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function edit(Faculty $faculty)
    {
        return Inertia::render('Faculties/EditFacultyForm',['faculty' => $faculty]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFaculty $request, Faculty $faculty)
    {
        $faculty-> update($request->all());
        request()->session()->flash('flash.banner', "Facultad {$faculty->name} Actualizada ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('faculties.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faculty $faculty)
    {
        $faculty->delete();
        request()->session()->flash('flash.banner', "Facultad {$faculty->name} Eliminada");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('faculties.index');
    }

    public function import(Request $request)
    {
        $path = $request->file('file');
        
        Excel::import(new FacultiesImport, $path);
        request()->session()->flash('flash.banner', "Facultades Cargadas desde Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('faculties.index');
    }

    public function export()
    {
        request()->session()->flash('flash.banner', "Facultades Respaldadas en Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Excel::download(new FacultiesExport,'faculties.xlsx');  
    }





/////////////////////////CHECK THIS///////////////////////


    public function getFaculties()
    {
        $faculties = Faculty::all();

        return response()->json($faculties);
    }

    public function getFaculty(Faculty $faculty)
    {
        $faculty = Faculty::where('id','=',$faculty->id);

        return response()->json($faculty);
    }

    
}
