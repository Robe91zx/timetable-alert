<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class WorkshopController extends Controller
{
    public function index()
    {
        
        $workshops = Workshop::with('courses')->get();

        if(request()->has("name")){
           $name = request("name");
            //no funciona el like en $subject->where(...)
            $workshops = Workshop::with('courses')
                        ->where('name','like','%'.$name.'%')->get();
        }
        return Inertia::render('ShowWorkshop',['workshops' => $workshops]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $workshops = Workshop::all();
        return Inertia::render('CreateWorkshopForm',['workshops' => $workshops]);
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

        Workshop::create($request->all());

        request()->session()->flash('message', "Ayudantia Creada");
        return Redirect::route('courses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Workshop $workshop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Workshop $workshop)
    {
        return Inertia::render('EditWorkshopForm',['workshop'=>$workshop]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Workshop $workshop)
    {
        $workshop-> update($request->all());
        request()->session()->flash('message', "Ayudantia Actualizada");
        return Redirect::route('workshops.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Workshop $workshop)
    {
        $workshop->delete();
        request()->session()->flash('message', "Ayudantia Eliminada");
        return Redirect::route('workshops.index');
    }
}
