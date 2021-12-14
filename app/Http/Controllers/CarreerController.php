<?php

namespace App\Http\Controllers;

use App\Models\Carreer;
use App\Models\Curriculum;
use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCarreer;
use App\Http\Requests\UpdateCarreer;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Excel;
use App\Imports\CarreersImport;
use App\Exports\CarreersExport;
use Illuminate\Database\Eloquent\Builder;

class CarreerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = Carreer::CARREERS_COLUMNS;
        $options = Carreer::CARREERS_OPTIONS;

        if(request()->has("name")){
           $carreers = Faculty::with(['carreers' => fn($query) => $query->where('name', 'LIKE', '%'.request("name").'%')])
              ->whereHas('carreers', fn ($query) => $query->where('name', 'LIKE', '%'.request("name").'%')
           )->get();
        }
        else{
            $carreers = Faculty::with('carreers')->get();
        }

        return Inertia::render('Carreers/ShowCarreers',['carreers'=> $carreers,'columns'=> $columns,'options'=> $options]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCarreer $request)
    {            
        Carreer::create($request->all());
        request()->session()->flash('flash.banner', "Recurso: {$request->name} Creado ");
        request()->session()->flash('flash.bannerStyle', 'success');         
    
        return Redirect::route('carreers.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Carreer $carreer)
    {
        //
    }

    public function showCurriculums(Carreer $carreer)
    {
        $CurriculumsOf = Carreer::with('curriculums')->where('vcode','=',$carreer->vcode)->get();
        $columns = Carreer::CURRICULUMS_COLUMNS;

        return Inertia::render('Carreers/Curriculums/CurriculumsOfCarreer', ['CurriculumsOf' => $CurriculumsOf, 'columns' => $columns]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Carreer $carreer)
    {
        return Inertia::render('Carreers/EditCarreerForm', ['carreer' => $carreer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCarreer $request, Carreer $carreer)
    {
        $carreer-> update($request->all());
        request()->session()->flash('flash.banner', "Recurso: {$carreer->name} Actualizado ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('carreers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carreer $carreer)
    {
        $carreer->delete();
        request()->session()->flash('flash.banner', "Recurso: {$carreer->name} Eliminado");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('carreers.index');
    }

    public function import(Request $request)
    {
        $path = $request->file('file');
        
        Excel::import(new CarreersImport, $path);
        request()->session()->flash('flash.banner', "Carreras Cargadas desde Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('carreers.index');
    }

    public function export()
    {
        request()->session()->flash('flash.banner', "Carreras Respaldadas en Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Excel::download(new CarreersExport,'carreers.xlsx');
    }

    public function getCarreers(Request $request)
    {
        $carreers = Carreer::with(['faculties' => fn($query) => $query->where('vcode', $request->faculty)])
        ->whereHas('faculties', fn($query) => $query->where('vcode', $request->faculty)
        )->get();
        
        return response()->json($carreers);
    }
}
