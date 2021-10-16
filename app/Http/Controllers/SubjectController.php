<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use App\Models\Subject;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $subjects = Subject::with('curriculums')->get();

        if(request()->has("name")){
            $name = request("name");
            //no funciona el like en $subject->where(...)
            $subjects = Subject::with('curriculums')
                        ->where('name','like','%'.$name.'%')->get();
        }
        //dd($subjects);
        return Inertia::render('ShowSubject',['subjects' => $subjects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $curriculums = Curriculum::all();
        return Inertia::render('CreateSubjectForm',['curriculums' => $curriculums]);
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
            'department' => 'required',
            'total_hour' => 'required',
            'department' => 'required',
            'requisite' => 'required',
            'state' => 'required',
            'workshop' => 'required',
            'laboratory' => 'required',
            'equivalence' => 'required',
            'curriculum_id' => 'required'
        ]);

        Subject::create($request->all());

        request()->session()->flash('message', "Asignatura Registrada");
        return Redirect::route('subjects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        return Inertia::render('EditSubjectForm',['subject'=>$subject]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        $subject-> update($request->all());
        request()->session()->flash('message', "Asignatura Modificada");
        return Redirect::route('subjects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        request()->session()->flash('message', "Asignatura Eliminada");
        return Redirect::route('subjects.index');
    }
    //Metodos Personalizados
    public function getSubjects(Request $request)
    {
        if($request->ajax()){
            $subjects = Subject::where('curriculum_id', $request->curriculum_id)->get();
        }
        return response()->json($subjects);

    }

    public function getSubjects2(Request $request)
    {
        if($request->ajax()){
            $subjects2 = Subject::where('curriculum_id', $request->curriculum_id)->get();
        }
        return response()->json($subjects2);

    }
}
