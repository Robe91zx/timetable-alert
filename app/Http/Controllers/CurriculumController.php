<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class CurriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $curriculums = Curriculum::all();
        return Inertia::render('ShowCurriculum',['curriculums' => $curriculums]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('CreateCurriculumForm');
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
            'faculty' => 'required',
            'total_hour' => 'required',
            'carreer_at' => 'required',
            'state' => 'required',
        ]);

        Curriculum::create($request->all());
        return Redirect::route('curriculums.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Curriculum  $curriculum
     * @return \Illuminate\Http\Response
     */
    public function show(Curriculum $curriculum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Curriculum  $curriculum
     * @return \Illuminate\Http\Response
     */
    public function edit(Curriculum $curriculum)
    {
        return Inertia::render('EditCurriculumForm',['curriculum'=>$curriculum]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Curriculum  $curriculum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Curriculum $curriculum)
    {
        $curriculum-> update($request->all());

        return Redirect::route('curriculums.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Curriculum  $curriculum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Curriculum $curriculum)
    {
        $curriculum->delete();
        return Redirect::route('curriculums.index');
    }

    public function getCurriculums()
    {
       $curriculums = Curriculum::all();
       return response()->json($curriculums);
    }

    public function otherCurriculums(Request $request)
    {
        if($request->ajax()){
            $othercurriculums = Curriculum::where('id' , '!=',$request->curriculum_id)->get();
        }
        return response()->json($othercurriculums);

    }
}
