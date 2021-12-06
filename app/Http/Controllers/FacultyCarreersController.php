<?php

namespace App\Http\Controllers;

use App\Models\FacultyCarreer;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCarreersOfFaculty;
use App\Http\Requests\UpdateCarreersOfFaculty;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\Faculty;
use App\Models\Carreer;
use Excel;
use App\Imports\FacultyandCarreerImport;
use App\Exports\FacultyandCarreerExport;

class FacultyCarreersController extends Controller
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
        $carreers = Carreer::select('vcode','name')->get();

        return response()->json([$faculties, $carreers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCarreersOfFaculty $request)
    {
        FacultyCarreer::create([
            'faculty_vcode' => $request->faculty_id['vcode'],
            'carreer_vcode' => $request->carreer_id['vcode']
        ]);

        request()->session()->flash('flash.banner', "Escuela {$request->carreer_id['name']} asignado a Facultad {$request->faculty_id['name']}");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('faculties.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FacultyCarreer  $facultyCarreer
     * @return \Illuminate\Http\Response
     */
    public function show(FacultyCarreer $facultyCarreer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FacultyCarreer  $facultyCarreer
     * @return \Illuminate\Http\Response
     */
    public function edit(FacultyCarreer $facultyCarreer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FacultyCarreer  $facultyCarreer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FacultyCarreer $facultyCarreer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FacultyCarreer  $facultyCarreer
     * @return \Illuminate\Http\Response
     */
    public function destroy(FacultyCarreer $facultyCarreer)
    {
        //
    }

    public function import(Request $request)
    {
        $path = $request->file('file');
        
        Excel::import(new FacultyandCarreerImport, $path);
        request()->session()->flash('flash.banner', "Relacion Facultad - Carrera Cargadas desde Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('faculties.index');
    }

    public function export()
    {
        request()->session()->flash('flash.banner', "Relacion Facultad - Carrera Respaldadas en Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Excel::download(new FacultyandCarreerExport,'facultiesandcarreers.xlsx');      
    }
}
