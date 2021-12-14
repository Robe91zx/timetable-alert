<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use App\Models\Subject;
use App\Models\Curriculum_hasSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Excel;
use App\Imports\Curriculum_hasSubjectImport;
use App\Exports\Curriculum_hasSubjectExport;
use App\Http\Requests\StoreCurriculum_hasSubject;
use App\Http\Requests\UpdateCurriculum_hasSubject;

class Curriculum_has_SubjectController extends Controller
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
    public function store(StoreCurriculum_hasSubject $request)
    {
        Curriculum_hasSubject::create([
            'curriculum_vcode' => $request->curriculum_id['vcode'],
            'subject_vcode' => $request->subject_id['vcode']
        ]);

        request()->session()->flash('flash.banner', "La Asignatura {$request->subject_id['name']} ha sido asignado a la Malla {$request->curriculum_id['name']}");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('curriculums.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Curriculum_hasSubject  $curriculum_hasSubject
     * @return \Illuminate\Http\Response
     */
    public function show(Curriculum_hasSubject $curriculum_hasSubject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Curriculum_hasSubject  $curriculum_hasSubject
     * @return \Illuminate\Http\Response
     */
    public function edit(Curriculum_hasSubject $curriculum_hasSubject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Curriculum_hasSubject  $curriculum_hasSubject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Curriculum_hasSubject $curriculum_hasSubject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Curriculum_hasSubject  $curriculum_hasSubject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Curriculum_hasSubject $curriculum_hasSubject)
    {
        //
    }

    public function import(Request $request)
    {
        $path = $request->file('file');
        
        Excel::import(new Curriculum_hasSubjectImport, $path);
        request()->session()->flash('flash.banner', "Relacion Facultad - Carrera Cargadas desde Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('departments.index');
    }

    public function export()
    {
        request()->session()->flash('flash.banner', "Relacion Facultad - Carrera Respaldadas en Excel ");
        request()->session()->flash('flash.bannerStyle', 'success');

        return Excel::download(new Curriculum_hasSubjectExport,'facultiesandcarreers.xlsx');      
    }

}
