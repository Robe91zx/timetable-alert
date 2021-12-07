<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use App\Models\Carreer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\StoreCurriculum;
use App\Http\Requests\UpdateCurriculum;
use Illuminate\Support\Facades\Redirect;
use Excel;
use App\Imports\CurriculumsImport;
use App\Exports\CurriculumsExport;
use Illuminate\Database\Eloquent\Builder;

class CurriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = Curriculum::CURRICULUMS_COLUMNS;
        $options = Curriculum::CURRICULUMS_OPTIONS;

        if(request()->has("name")){
            $curriculums = Carreer::with(['curriculums' => fn($query) => $query->where('name', 'LIKE', '%'.request("name").'%')])
               ->whereHas('curriculums', fn ($query) => $query->where('name', 'LIKE', '%'.request("name").'%')
            )->get();
         }
        else{
            $curriculums = Carreer::with('curriculums')->get();
        }

        return Inertia::render('Curriculums/ShowCurriculum', ['curriculums' => $curriculums, 'columns' => $columns, 'options' => $options ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCurriculum $request)
    {
        Curriculum::create($request->all());

        request()->session()->flash('flash.banner', "Recurso: {$request->name} Creado ");
        request()->session()->flash('flash.bannerStyle', 'success');  
        
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

    public function showSubjects(Curriculum $curriculum)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Curriculum  $curriculum
     * @return \Illuminate\Http\Response
     */
    public function edit(Curriculum $curriculum)
    {
        return Inertia::render('Curriculums/EditCurriculumForm', ['curriculum'=>$curriculum]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Curriculum  $curriculum
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCurriculum $request, Curriculum $curriculum)
    {
        $curriculum-> update($request->all());
        request()->session()->flash('flash.banner', "Recurso: {$curriculum->name} Actualizado ");
        request()->session()->flash('flash.bannerStyle', 'success');  

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
        request()->session()->flash('flash.banner', "Recurso: {$curriculum->name} Eliminado ");
        request()->session()->flash('flash.bannerStyle', 'success');  

        return Redirect::route('curriculums.index');
    }

    public function remove(Request $request)
    {
        $curriculum->update(['carreer_vcode' => '0']);
        
        return response()->json($curriculum);
    }

    public function activate(Curriculum $curriculum)
    {
        
        

        return response()->json($curriculum);
    }

    public function deactivate(Curriculum $curriculum)
    {
        $curriculum->update(['state' => '0']);
    
        return response()->json($curriculum);
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



    public function import(Request $request)
    {
        $request->validate([
           'file' => 'required|max:10000|mimes:xlsx,xls',
        ]);
        $path = $request->file('file');
        
        Excel::import(new CurriculumsImport, $path);
        request()->session()->flash('message', "Mallas Cargadas ");

        return Redirect::route('curriculums.index');
    }

    public function export()
    {
        request()->session()->flash('message', "Archivo Generado");
        return Excel::download(new CurriculumsExport,'curriculums.xlsx');
    }
}
