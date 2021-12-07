<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Faculty;
use App\Models\Faculty_hasCollege;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Excel;
use App\Imports\Faculty_hasCollegeImport;
use App\Exports\Faculty_hasCollegeExport;
use App\Http\Requests\StoreFaculty_hasCollege;
use App\Http\Requests\UpdateFaculty_hasCollege;

class Faculty_has_CollegeController extends Controller
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
        $colleges = College::select('vcode','name')->get();

        return response()->json([$faculties, $colleges]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFaculty_hasCollege $request)
    {
        Faculty_hasCollege::create([
            'faculty_vcode' => $request->faculty_id['vcode'],
            'college_vcode' => $request->college_id['vcode']
        ]);

        request()->session()->flash('flash.banner', "Escuela {$request->college_id['name']} asignado a Facultad {$request->faculty_id['name']}");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('faculties.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faculty_hasCollege  $faculty_hasCollege
     * @return \Illuminate\Http\Response
     */
    public function show(Faculty_hasCollege $faculty_hasCollege)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faculty_hasCollege  $faculty_hasCollege
     * @return \Illuminate\Http\Response
     */
    public function edit(Faculty_hasCollege $faculty_hasCollege)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faculty_hasCollege  $faculty_hasCollege
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faculty_hasCollege $faculty_hasCollege)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faculty_hasCollege  $faculty_hasCollege
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faculty_hasCollege $faculty_hasCollege)
    {
        dd($facultiesanddepartment);
        $facultiesanddepartment->delete();
        request()->session()->flash('message', "Relacion Eliminada");
        return Redirect::route('faculties.index');
    }

    public function import(Request $request)
    {
        $path = $request->file('file');
        
        Excel::import(new Faculty_hasCollegeImport, $path);
        request()->session()->flash('flash.banner', "Relacion Facultad - Escuela Cargadas desde Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('faculties.index');
    }

    public function export()
    {
        request()->session()->flash('flash.banner', "Relacion Facultad - Escuela Respaldadas en Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Excel::download(new Faculty_hasCollegeExport,'facultiesandcolleges.xlsx');      
    }
}
