<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Carreer;
use App\Models\College_hasCarreer;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Excel;
use App\Imports\College_hasCarreerImport;
use App\Exports\College_hasCarreerExport;
use App\Http\Requests\StoreCollege_hasCarreer;
use App\Http\Requests\UpdateCollege_hasCarreer;

class College_has_CarreerController extends Controller
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
    public function store(StoreCollege_hasCarreer $request)
    {
        College_hasCarreer::create([
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(College_hasCarreer $college_hasCarreer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(College_hasCarreer $college_hasCarreer)
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
    public function update(UpdateCollege_hasCarreer $request, College_hasCarreer $college_hasCarreer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(College_hasCarreer $college_hasCarreer)
    {
        //
    }

    public function import(Request $request)
    {
        $path = $request->file('file');
        
        Excel::import(new College_hasCarreerImport, $path);
        request()->session()->flash('flash.banner', "Relacion Escuela - Carrera Cargadas desde Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('colleges.index');
    }

    public function export()
    {
        request()->session()->flash('flash.banner', "Relacion Escuela - Carrera Respaldadas en Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Excel::download(new College_hasCarreerExport,'collegesandcarreers.xlsx');      
    }
}
