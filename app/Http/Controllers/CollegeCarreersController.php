<?php

namespace App\Http\Controllers;

use App\Models\CollegeCarreer;
use App\Models\College;
use App\Models\Carreer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Excel;
use App\Imports\CollegeandCarreerImport;
use App\Exports\CollegeandCarreerExport;
use App\Http\Requests\StoreCarreersOfCollege;
use App\Http\Requests\UpdateCarreersOfCollege;

class CollegeCarreersController extends Controller
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
        $colleges = College::select('vcode','name')->get();
        $carreers = Carreer::select('vcode','name')->get();

        return response()->json([$colleges, $carreers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCarreersOfCollege $request)
    {
        CollegeCarreer::create([
            'college_vcode' => $request->college_id['vcode'],
            'carreer_vcode' => $request->carreer_id['vcode']
        ]);

        request()->session()->flash('flash.banner', "Carrera {$request->carreer_id['name']} asignado a la Escuela de {$request->college_id['name']}");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('colleges.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CollegeCarreer  $collegeCarreer
     * @return \Illuminate\Http\Response
     */
    public function show(CollegeCarreer $collegeCarreer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CollegeCarreer  $collegeCarreer
     * @return \Illuminate\Http\Response
     */
    public function edit(CollegeCarreer $collegeCarreer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CollegeCarreer  $collegeCarreer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CollegeCarreer $collegeCarreer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CollegeCarreer  $collegeCarreer
     * @return \Illuminate\Http\Response
     */
    public function destroy(CollegeCarreer $collegeCarreer)
    {
        //
    }

    public function import(Request $request)
    {
        $path = $request->file('file');
        
        Excel::import(new CollegeandCarreerImport, $path);
        request()->session()->flash('flash.banner', "Relacion Escuela - Carrera Cargadas desde Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('colleges.index');
    }

    public function export()
    {
        request()->session()->flash('flash.banner', "Relacion Escuela - Carrera Respaldadas en Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Excel::download(new CollegeandCarreerExport,'collegesandcarreers.xlsx');      
    }
}
