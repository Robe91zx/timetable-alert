<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreCourse;
use App\Http\Requests\UpdateCourse;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = Course::COURSE_COLUMNS;
        $options = Course::COURSE_OPTIONS;

        if(request()->has("name")){
            $name = request("name");
            $courses = Subject::with('courses')->get ();
            
            /*Course::with('subjects')
                       ->join('subjects','courses.subject_id', '=','subjects.id') 
                       ->where('subjects.name','like','%'.$name.'%')->get();
        */ }else{
            $courses = Subject::with('courses')->get();
        }
        return Inertia::render('Courses/ShowCourse', ['subjects' => $courses, 'columns' => $columns, 'options' => $options]);
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
    public function store(StoreCourse $request)
    {
        Course::create($request->all());
        request()->session()->flash('flash.banner', "Curso {$request->name} Creado");
        request()->session()->flash('flash.bannerStyle', 'success');     
        
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
        return Inertia::render('EditCourseForm', ['course' => $course]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCourse $request, Course $course)
    {
        $course-> update($request->all());
        request()->session()->flash('flash.banner', "Curso {$request->name} Actualizado ");
        request()->session()->flash('flash.bannerStyle', 'success');  
        
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
