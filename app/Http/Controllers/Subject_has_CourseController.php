<?php

namespace App\Http\Controllers;

use App\Models\Subject_has_Course;
use Illuminate\Http\Request;

class Subject_has_CourseController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject_has_Course  $subject_has_Course
     * @return \Illuminate\Http\Response
     */
    public function show(Subject_has_Course $subject_has_Course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject_has_Course  $subject_has_Course
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject_has_Course $subject_has_Course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject_has_Course  $subject_has_Course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject_has_Course $subject_has_Course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject_has_Course  $subject_has_Course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject_has_Course $subject_has_Course)
    {
        //
    }

    public function import(Request $request)
    {
        $path = $request->file('file');
        
        Excel::import(new Subject_hasCourseImport, $path);
        request()->session()->flash('flash.banner', "Relacion Asignatura - Cursos Cargadas desde Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('subjects.index');
    }

    public function export()
    {
        request()->session()->flash('flash.banner', "Relacion Asignatura - Cursos Respaldadas en Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Excel::download(new Subject_hasCourseExport,'subjectsandcourses.xlsx');      
    }
}
