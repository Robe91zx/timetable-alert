<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::with('subjects')->get();
        
        if(request()->has("name")){
            $name = request("name");
            $courses = Course::with('subjects')
                       ->join('subjects','courses.subject_id', '=','subjects.id') 
                       ->where('subjects.name','like','%'.$name.'%')->get();
        }
        return Inertia::render('ShowCourse',['courses' => $courses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = Subject::all();
        return Inertia::render('CreateCourseForm', ['subjects' => $subjects]);
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
            'state' => 'required',
            'semester' => 'required',
            'hours' => 'required',
            'description' => 'required',
            'group' => 'required',
            'subject_id' => 'required',
        ]);

        Course::create($request->all());
        request()->session()->flash('message', "Curso Creado");
        return Redirect::route('courses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        return Inertia::render('EditCourseForm',['course'=>$course]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $course-> update($request->all());
        request()->session()->flash('message', "Curso Actualizado");
        return Redirect::route('courses.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return Redirect::route('courses.index');
    }
}
