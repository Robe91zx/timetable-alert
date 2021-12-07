<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Carreer;
use App\Models\Faculty_hasCarreer;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Excel;
use App\Imports\Faculty_hasCarreerImport;
use App\Exports\Faculty_hasCarreerExport;
use App\Http\Requests\StoreFaculty_hasCarreer;
use App\Http\Requests\UpdateFaculty_hasCarreer;

class Faculty_has_CarreerController extends Controller
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
    public function store(StoreFaculty_hasCarreer $request)
    {
        Faculty_hasCarreer::create([
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
     * @param  \App\Models\Faculty_hasCarreer  $faculty_hasCarreer
     * @return \Illuminate\Http\Response
     */
    public function show(Faculty_hasCarreer $faculty_hasCarreer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faculty_hasCarreer  $faculty_hasCarreer
     * @return \Illuminate\Http\Response
     */
    public function edit(Faculty_hasCarreer $faculty_hasCarreer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faculty_hasCarreer  $faculty_hasCarreer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faculty_hasCarreer $faculty_hasCarreer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faculty_hasCarreer  $faculty_hasCarreer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faculty_hasCarreer $faculty_hasCarreer)
    {
        //
    }

    public function import(Request $request)
    {
        $path = $request->file('file');
        
        Excel::import(new Faculty_hasCarreerImport, $path);
        request()->session()->flash('flash.banner', "Relacion Facultad - Carrera Cargadas desde Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('faculties.index');
    }

    public function export()
    {
        request()->session()->flash('flash.banner', "Relacion Facultad - Carrera Respaldadas en Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Excel::download(new Faculty_hasCarreerExport,'facultiesandcarreers.xlsx');      
    }
}
