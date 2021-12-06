<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\College;
use App\Http\Requests\StoreCollege;
use App\Http\Requests\UpdateCollege;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Excel;
use App\Imports\CollegesImport;
use App\Exports\CollegesExport;

class CollegeController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = College::COLLEGES_COLUMNS;
        $options = College::COLLEGES_OPTIONS;

        if(request()->has("name")){
            $name = request("name");
            $colleges = College::where('name','like','%'.$name.'%')->get();
        
        }else{ $colleges = College::all();}

        return Inertia::render('Colleges/ShowColleges',['colleges' => $colleges, 'columns' => $columns, 'options' => $options]);
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
    public function store(StoreCollege $request)
    {
        College::create($request->all());
        request()->session()->flash('flash.banner', "Recurso: {$request->name} Creado ");
        request()->session()->flash('flash.bannerStyle', 'success');    

        return Redirect::route('colleges.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Collegue  $collegue
     * @return \Illuminate\Http\Response
     */
    public function show(College $college)
    {
        $columns = College::COLLEGES_COLUMNS;
        $CarreersOf = College::with('carreers')->where('id','=',$college->id)->get();   

        return Inertia::render('Colleges/Carreers/CarreersOfColleges', [ 'CarreersOf' => $CarreersOf, 'columns' => $columns]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function edit(College $college)
    {
        return Inertia::render('Colleges/EditCollegeForm',['college' => $college]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCollege $request, College $college)
    {
        $college-> update($request->all());
        request()->session()->flash('flash.banner', "Recurso: {$college->name} Actualizado ");
        request()->session()->flash('flash.bannerStyle', 'success'); 

        return Redirect::route('colleges.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function destroy(College $college)
    {
        $college->delete();
        request()->session()->flash('flash.banner', "Recurso: {$college->name} Eliminado ");
        request()->session()->flash('flash.bannerStyle', 'success'); 

        return Redirect::route('colleges.index');
    }

    public function getColleges(){
        $departments = College::all();

        return response()->json($colleges);
    }

    public function import(Request $request)
    {   
        $path = $request->file('file');
        
        Excel::import(new CollegesImport, $path);
        request()->session()->flash('flash.banner', "Escuelas Cargadas desde Excel ");
        request()->session()->flash('flash.bannerStyle', 'success'); 

        return Redirect::route('colleges.index');
    }

    public function export()
    {
        request()->session()->flash('flash.banner', "Escuelas Respaldadas a Excel ");
        request()->session()->flash('flash.bannerStyle', 'success'); 

        return Excel::download(new CollegesExport,'colleges.xlsx');
    }
}
