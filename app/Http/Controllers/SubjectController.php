<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Faculty;
use App\Models\Curriculum;
//aca van los has
use App\Http\Requests\StoreSubject;
use App\Http\Requests\UpdateSubject;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Excel;
use App\Imports\SubjectImport;
use App\Exports\SubjectExport;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = Subject::SUBJECTS_COLUMNS;
        $options = Subject::SUBJECTS_OPTIONS;

        if(request()->has("name")){
            $subjects = Faculty::with(['subjects' => fn($query) => $query->where('name', 'LIKE', '%'.request("name").'%')])
               ->whereHas('subjects', fn ($query) => $query->where('name', 'LIKE', '%'.request("name").'%')
            )->get();
         }else{
            $subjects = Faculty::with('subjects')->get();
        }
        
        return Inertia::render('Subjects/ShowSubject',['subjects' => $subjects, 'columns' => $columns, 'options' => $options]);
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
    public function store(StoreSubject $request)
    {
        Subject::create($request->all());

        request()->session()->flash('flash.banner', "Asignatura {$request->name} Registrada ");
        request()->session()->flash('flash.bannerStyle', 'success');
        
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
    
     public function showCourses(Subject $subject)
    {
        $columns = Subject::SUBJECT_COURSES_COLUMNS;
        $AllOf = Subject::with('courses')->where('vcode','=',$subject->vcode)->get();

        return Inertia::render('Subjects/Courses/CoursesOfSubject', ['CoursesOf'=> $AllOf, 'columns'=> $columns]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        return Inertia::render('Subjects/EditSubjectForm', [ 'subject' => $subject]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubject $request, Subject $subject)
    {
        $subject-> update($request->all());
        request()->session()->flash('flash.banner', "Asignatura {$request->name} Actualizada ");
        request()->session()->flash('flash.bannerStyle', 'success');

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
        request()->session()->flash('flash.banner', "Asignatura {$subject->name} Eliminada ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('subjects.index');
    }

    public function import(Request $request)
    {
        $path = $request->file('file');

        Excel::import(new SubjectImport, $path);
        request()->session()->flash('flash.banner', "Asignaturas Cargadas desde Excel");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('subjects.index');
    }

    public function export()
    {
        request()->session()->flash('flash.banner', "Asignaturas Respaldadas en Excel");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Excel::download(new SubjectsExport,'subjects.xlsx');
    }

/////////////////////////////////////////////////////////////////
    public function ChangeGlobalState(Request $request)
    {
        if($request == 1){
            Subject::where('state', 0)->update(['state' => 1]);
        }else{
            Subject::where('state', 1)->update(['state' => 0]);
        }
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

    public function storemultiple(Request $request)
    {

        $elements = $request->all();
        $subjects = json_decode($request->all());
        return $subjects;
    }  
}
