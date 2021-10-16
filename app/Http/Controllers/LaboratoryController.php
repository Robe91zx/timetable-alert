<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Laboratory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class LaboratoryController extends Controller
{
    public function index()
    {
        
        $laboratories = Laboratory::with('courses')->get();

        if(request()->has("name")){
           $name = request("name");
            //no funciona el like en $subject->where(...)
            $laboratories = Laboratory::with('courses')
                        ->where('name','like','%'.$name.'%')->get();
        }
        return Inertia::render('ShowLaboratory',['laboratories' => $laboratories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $laboratories = Laboratory::all();
        return Inertia::render('CreateLaboratoryForm',['laboratories' => $laboratories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'hours' => 'required',
            'course_id' => 'required'
        ]);

        Laboratory::create($request->all());

        request()->session()->flash('message', "Laboratorio Creado");
        return Redirect::route('courses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Laboratory  $laboratory
     * @return \Illuminate\Http\Response
     */
    public function show(Laboratory $laboratory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Laboratory  $laboratory
     * @return \Illuminate\Http\Response
     */
    public function edit(Laboratory $laboratory)
    {
        return Inertia::render('EditLaboratoryForm',['laboratory'=>$laboratory]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Laboratory  $waboratory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Laboratory $laboratory)
    {
        $laboratory-> update($request->all());
        request()->session()->flash('message', "Laboratorio Actualizado");
        return Redirect::route('laboratories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Laboratory  $laboratory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Laboratory $laboratory)
    {
        $laboratory->delete();
        request()->session()->flash('message', "Laboratorio Eliminado");
        return Redirect::route('laboratories.index');
    }
}
