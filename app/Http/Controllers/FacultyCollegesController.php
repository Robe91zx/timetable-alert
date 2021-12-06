<?php

namespace App\Http\Controllers;

use App\Models\FacultyCollege;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCollegesOfFaculty;
use App\Http\Requests\UpdateCollegesOfFaculty;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\College;
use App\Models\Faculty;
use Excel;
use App\Imports\FacultyandCollegeImport;
use App\Exports\FacultyandCollegeExport;

class FacultyCollegesController extends Controller
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
    public function store(StoreCollegesOfFaculty $request)
    {
        FacultyCollege::create([
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
    public function update(UpdateCollegesOfFaculty $request, $id)
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
        
        Excel::import(new FacultyandCollegeImport, $path);
        request()->session()->flash('flash.banner', "Relacion Facultad - Escuela Cargadas desde Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('faculties.index');
    }

    public function export()
    {
        request()->session()->flash('flash.banner', "Relacion Facultad - Escuela Respaldadas en Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Excel::download(new FacultyandCollegeExport,'facultiesandcolleges.xlsx');      
    }
}
