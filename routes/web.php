<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Roles\RoleController;
use App\Http\Controllers\Roles\PermissionController;
use App\Http\Controllers\Roles\AdministrationController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CollegeController;


use App\Http\Controllers\Faculty_has_DepartmentController;
use App\Http\Controllers\College_has_CarreerController;
use App\Http\Controllers\Department_has_CarreerController;


use App\Http\Controllers\Faculty_has_CollegeController;
use App\Http\Controllers\Faculty_has_CarreerController;

use App\Http\Controllers\Curriculum_has_SubjectController;
use App\Http\Controllers\Subject_has_CourseController;




use App\Http\Controllers\CarreerController;
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
  
  //Resources Route
  ///// USUARIOS ////////
  Route::middleware(['auth:sanctum', 'verified'])->resource('users', UserController::class)->parameters(['users' => 'member']); 
  Route::get('validate-user', [UserController::class,'getNonRoleUsers'])->name('users.getNonRoleUsers');
  
  
  ////// ROLES ////////
  Route::resource('roles', RoleController::class)->middleware(['auth:sanctum', 'verified']); 
  Route::get('get-roles', [RoleController::class,'getRoles'])->name('roles.getRoles');


  //////PERMISOS ///////////
  Route::resource('permissions', PermissionController::class)->middleware(['auth:sanctum', 'verified']);
  Route::get('get-permissions', [ PermissionController::class,'getPermissions'])->name('permissions.getPermissions');

  //////RELACION ROLES - PERMISOS ///////////
  Route::resource('rolesandpermissions', AdministrationController::class)->middleware(['auth:sanctum', 'verified']); 
  Route::get('role-permissions', [AdministrationController::class,'getRolePermissions'])->name('rolesandpermissions.getRolePermissions');



  //////FACULTADES////////////////
  /*LISTO*/Route::resource('faculties', FacultyController::class)->middleware(['auth:sanctum', 'verified']);  
  /*LISTO*/Route::get('faculty/departments-and-colleges/{faculty}', [FacultyController::class,'showDepartmentsandColleges'])->name('faculties.showDepartmentsandColleges');
  /*LISTO*/Route::get('faculty/carreers/{faculty}', [FacultyController::class,'showCarreers'])->name('faculties.showCarreers');
  /*LISTO*/Route::get('faculty/subject/{faculty}', [FacultyController::class,'showSubjects'])->name('faculties.showSubjects');
  /*LISTO*/ Route::get('faculties-import', [FacultyController::class,'import'])->name('faculties.import');
  /*LISTO*/Route::get('faculties-export', [FacultyController::class,'export'])->name('faculties.export');
  /*LISTO*/Route::get('faculties-all', [FacultyController::class,'getFaculties'])->name('faculties.getFaculties');
  /*LISTO*/Route::get('faculty-subjects', [FacultyController::class,'getFacultySubjects'])->name('faculties.getFacultySubjects');
  /*LISTO*/Route::get('faculty-active-subjects', [FacultyController::class,'getactiveSubjects'])->name('faculties.getactiveSubjects');

  
  //////////////////////DEPARTMENTS//////////////
  /*LISTO*/Route::resource('departments', DepartmentController::class)->middleware(['auth:sanctum', 'verified']); 
  /*LISTO*/Route::get('all-departments', [DepartmentController::class,'getDepartments'])->name('departments.getDepartments');
  /*LISTO*/Route::get('departments-import', [DepartmentController::class,'import'])->name('departments.import');
  /*LISTO*/Route::get('departments-export', [DepartmentController::class,'export'])->name('departments.export');
  
  
  //////ESCUELAS/////////
  /*LISTO*/Route::resource('colleges', CollegeController::class)->middleware(['auth:sanctum', 'verified']); 
  /*LISTO*/Route::get('all-colleges', [CollegeController::class,'getColleges'])->name('departments.getColleges');
  /*LISTO*/Route::get('colleges-import', [CollegeController::class,'import'])->name('colleges.import');
  /*LISTO*/Route::get('colleges-export', [CollegeController::class,'export'])->name('colleges.export');
  
  /////////// CARRERAS /////////////
  /*LISTO*/Route::resource('carreers', CarreerController::class)->middleware(['auth:sanctum', 'verified']);   
  /*LISTO*/Route::get('carreer/curriculums/{carreer}', [CarreerController::class,'showCurriculums'])->name('carreers.showCurriculums');
  /*LISTO*/Route::get('carreers-import', [CarreerController::class,'import'])->name('carreers.import');
  /*LISTO*/Route::get('carreers-export', [CarreerController::class,'export'])->name('carreers.export');
  /*LISTO*/Route::get('get-carreer', [CarreerController::class,'getCarreers'])->name('carreers.getCarreers');


  //////// CURRICULUM //////////
  /*LISTO*/Route::resource('curriculums',CurriculumController::class)->middleware(['auth:sanctum', 'verified']);   
  /*LISTO*/Route::get('curriculum/subjects/{curriculum}', [CurriculumController::class,'showSubjects'])->name('curriculums.showSubjects');

  /*LISTO*/Route::get('curriculums-import', [CurriculumController::class, 'import'])->name('curriculums.import');
  /*LISTO*/Route::get('curriculums-export', [CurriculumController::class, 'export'])->name('curriculums.export');
  /*LISTO*/Route::get('get-curriculums', [CurriculumController::class,'getCurriculums'])->name('curriculums.getCurriculums');

    
    Route::get('curriculum2', [CurriculumController::class, 'otherCurriculums'])->name('curriculums.otherCurriculums');
    Route::match(['put','patch'],'carreer-remove', [CurriculumController::class,'remove'])->name('curriculums.remove');
    Route::match(['put','patch'],'curriculum-active', [CurriculumController::class,'activate'])->name('curriculums.activate');
    Route::match(['put','patch'],'curriculum-deactive', [CurriculumController::class,'deactivate'])->name('curriculums.deactivate');

  //////ASIGNATURAS
  /*LISTO*/Route::resource('subjects',SubjectController::class)->middleware(['auth:sanctum', 'verified']);
  /*LISTO*/ Route::get('subjects-import', [SubjectController::class,'import'])->name('subjects.import');
  /*LISTO*/Route::get('subjects-export', [SubjectController::class, 'export'])->name('subjects.export');
  /*LISTO*/Route::get('subject/courses/{subject}', [SubjectController::class,'showCourses'])->name('subjects.showCourses');

  
  Route::get('subject', [SubjectController::class, 'getSubjects'])->name('subjects.getSubjects');
  Route::get('subject2', [SubjectController::class, 'getSubjects2'])->name('subjects.getSubjects2');
  Route::get('subject3', [SubjectController::class, 'createmultiple'])->name('subjects.createmultiple');


//////CURSOS//////
Route::resource('courses',CourseController::class)->middleware(['auth:sanctum', 'verified']);

////LABORATORIOS///////
Route::resource('laboratories',LaboratoryController::class)->middleware(['auth:sanctum', 'verified']);  
  
/////// AYUDANTIAS ///////
Route::resource('workshops',WorkshopController::class)->middleware(['auth:sanctum', 'verified']);  

////// TIMAETABLE /////////
Route::resource('timetables',TimetableController::class)->middleware(['auth:sanctum', 'verified']);

//////// RELACION FACULTAD - DEPARTAMENTOS /////////
Route::resource('facultiesanddepartments', Faculty_has_DepartmentController::class)->middleware(['auth:sanctum', 'verified']); 
Route::get('facultiesanddepartments-import', [Faculty_has_DepartmentController::class, 'import'])->name('facultiesanddepartments.import');
Route::get('facultiesanddepartments-export', [Faculty_has_DepartmentController::class, 'export'])->name('facultiesanddepartments.export');  
Route::get('fd-create-relation', [Faculty_has_DepartmentController::class,'createRelation'])->name('facultiesanddepartments.createRelation');

//////// RELACION FACULTAD - ESCUELAS /////////
Route::resource('facultiesandcolleges', Faculty_has_CollegeController::class)->middleware(['auth:sanctum', 'verified']); 

//////// RELACION FACULTAD - CARRERAS /////////
Route::resource('facultiesandcarreers', Faculty_has_CarreerController::class)->middleware(['auth:sanctum', 'verified']);  
Route::get('facultiesandcarreers-import', [Faculty_has_CarreerController::class, 'import'])->name('facultiesandcarreers.import');
Route::get('facultiesandcarreers/export', [Faculty_has_CarreerController::class, 'export'])->name('facultiesandcarreers.export');


//////// RELACION DEPARTAMENTOS - CARRERAS /////////
Route::resource('departmentsandcarreers',Department_has_CarreerController::class)->middleware(['auth:sanctum', 'verified']);   
Route::get('departmentsandcarreers-import', [Department_has_CarreerController::class, 'import'])->name('departmentsandcarreers.import');
Route::get('departmentsandcarreers-export', [Department_has_CarreerController::class, 'export'])->name('departmentsandcarreers.export');


//////// RELACION FACULTAD - ESCUELAS /////////
Route::get('facultiesandcolleges-import', [Faculty_has_CollegeController::class, 'import'])->name('facultiesandcolleges.import');
Route::get('facultiesandcolleges-export', [Faculty_has_CollegeController::class, 'export'])->name('facultiesandcolleges.export');

//////// RELACION ESCUELAS - CARRERAS /////////
Route::resource('facultiesandcarreers', Faculty_has_CarreerController::class)->middleware(['auth:sanctum', 'verified']);  

Route::resource('collegesandcarreers',College_has_CarreerController::class)->middleware(['auth:sanctum', 'verified']);   
Route::get('collegesandcarreers-import', [College_has_CarreerController::class, 'import'])->name('collegesandcarreers.import');
Route::get('collegesandcarreers-export', [College_has_CarreerController::class, 'export'])->name('collegesandcarreers.export');

///////////RELACION CURRICULUM - ASIGNATURAS ////////////
Route::resource('curriculumsandsubjects', Curriculum_has_SubjectController::class)->middleware(['auth:sanctum', 'verified']);  
/*LISTO*/Route::get('curriculumsandsubjects-import', [Curriculum_has_SubjectController::class, 'import'])->name('curriculumsandsubjects.import');
/*LISTO*/Route::get('curriculumsandsubjects-export', [Curriculum_has_SubjectController::class, 'export'])->name('curriculumsandsubjects.export');


///////////RELACION ASIGNATURA - CURSOS ////////////
Route::resource('subjectsandcourses', Subject_has_CourseController::class)->middleware(['auth:sanctum', 'verified']);  
Route::get('subjectsandcourses-import', [Subject_has_CourseController::class, 'import'])->name('subjectsandcourses.import');
Route::get('subjectsandcourses-export', [Subject_has_CourseController::class, 'export'])->name('subjectsandcourses.export');
