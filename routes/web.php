<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\WorkshopController;
use App\Http\Controllers\LaboratoryController;
use App\Http\Controllers\TimetableController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

  Route::resource('curriculums',CurriculumController::class)
  ->middleware(['auth:sanctum', 'verified']);    

  Route::resource('subjects',SubjectController::class)
  ->middleware(['auth:sanctum', 'verified']);

  Route::resource('courses',CourseController::class)
  ->middleware(['auth:sanctum', 'verified']);

  Route::resource('workshops',WorkshopController::class)
  ->middleware(['auth:sanctum', 'verified']);  

  Route::resource('laboratories',LaboratoryController::class)
  ->middleware(['auth:sanctum', 'verified']);  

  Route::resource('timetables',TimetableController::class)
  ->middleware(['auth:sanctum', 'verified']);

  Route::get('subject', [SubjectController::class, 'getSubjects'])->name('subjects.getSubjects');
  Route::get('subject2', [SubjectController::class, 'getSubjects2'])->name('subjects.getSubjects2');
  Route::get('subject3', [SubjectController::class, 'createmultiple'])->name('subjects.createmultiple');
  Route::get('curriculum', [CurriculumController::class, 'getCurriculums'])->name('curriculums.getCurriculums');
  Route::get('curriculum2', [CurriculumController::class, 'otherCurriculums'])->name('curriculums.otherCurriculums');

  Route::get('import', [SubjectController::class,'import'])->name('subjects.import');
  Route::get('export', [SubjectController::class, 'export'])->name('subjects.export');
  