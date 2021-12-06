<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Roles\RoleController;
use App\Http\Controllers\Roles\PermissionController;
use App\Http\Controllers\Roles\AdministrationController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\FacultyDepartmentsController;
use App\Http\Controllers\FacultyCollegesController;
use App\Http\Controllers\FacultyCarreersController;
use App\Http\Controllers\DepartmentCarreersController;
use App\Http\Controllers\CollegeCarreersController;
use App\Http\Controllers\CarreerController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\WorkshopController;
use App\Http\Controllers\LaboratoryController;
use App\Http\Controllers\TimetableController;

use App\Http\Controllers\testingController;

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
  Route::middleware(['auth:sanctum', 'verified'])->resource('users', UserController::class)->parameters(['users' => 'member']); 
  Route::resource('roles', RoleController::class)->middleware(['auth:sanctum', 'verified']); 
  Route::resource('permissions', PermissionController::class)->middleware(['auth:sanctum', 'verified']);
  Route::resource('rolesandpermissions', AdministrationController::class)->middleware(['auth:sanctum', 'verified']);
  
  Route::resource('faculties', FacultyController::class)->middleware(['auth:sanctum', 'verified']);   
  Route::resource('departments', DepartmentController::class)->middleware(['auth:sanctum', 'verified']); 
  Route::resource('colleges', CollegeController::class)->middleware(['auth:sanctum', 'verified']); 
  Route::resource('facultiesanddepartments', FacultyDepartmentsController::class)->middleware(['auth:sanctum', 'verified']); 
  Route::resource('facultiesandcolleges', FacultyCollegesController::class)->middleware(['auth:sanctum', 'verified']); 
  Route::resource('facultiesandcarreers', FacultyCarreersController::class)->middleware(['auth:sanctum', 'verified']); 
  Route::resource('departmentsandcarreers',DepartmentCarreersController::class)->middleware(['auth:sanctum', 'verified']);   
  Route::resource('collegesandcarreers',CollegeCarreersController::class)->middleware(['auth:sanctum', 'verified']);   

  Route::resource('carreers', CarreerController::class)->middleware(['auth:sanctum', 'verified']); 
  Route::resource('curriculums',CurriculumController::class)->middleware(['auth:sanctum', 'verified']);   


  Route::resource('testing', testingController::class)->middleware(['auth:sanctum', 'verified']); 


  //Custom method Route
  Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('all-faculties', [FacultyController::class,'getFaculties'])->name('faculties.getFaculties');
    Route::get('faculty/{id}', [FacultyController::class,'getFaculty'])->name('faculties.getFaculty');
    Route::get('all-departments', [DepartmentController::class,'getDepartments'])->name('departments.getDepartments');

    Route::get('faculties-subject/{faculty}', [FacultyController::class,'showSubjects'])->name('faculties.showSubjects');
    Route::get('faculties-departments/{faculty}', [FacultyController::class,'showDepartments'])->name('faculties.showDepartments');
    Route::get('faculties-carreers/{faculty}', [FacultyController::class,'showCarreers'])->name('faculties.showCarreers');
    Route::get('carreers-curriculums/{carreer}', [CarreerController::class,'showCurriculums'])->name('carreers.showCurriculums');

    Route::get('all-colleges', [CollegeController::class,'getColleges'])->name('departments.getColleges');

    Route::get('fd-create-relation', [FacultyDepartmentsController::class,'createRelation'])->name('facultiesanddepartments.createRelation');
    Route::get('all-carreers', [CarreerController::class,'getCarreers'])->name('carreers.getCarreers');

    Route::match(['put','patch'],'carreer-remove', [CurriculumController::class,'remove'])->name('curriculums.remove');
    Route::match(['put','patch'],'curriculum-active', [CurriculumController::class,'activate'])->name('curriculums.activate');
    Route::match(['put','patch'],'curriculum-deactive', [CurriculumController::class,'deactivate'])->name('curriculums.deactivate');



  });

  //Excel Import/Export Route
  Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('validate-user', [UserController::class,'getNonRoleUsers'])->name('users.getNonRoleUsers');
    Route::get('get-roles', [RoleController::class,'getRoles'])->name('roles.getRoles');
    Route::get('get-permissions', [ PermissionController::class,'getPermissions'])->name('permissions.getPermissions');
    Route::get('role-permissions', [AdministrationController::class,'getRolePermissions'])->name('rolesandpermissions.getRolePermissions');




    Route::get('faculties-import', [FacultyController::class,'import'])->name('faculties.import');
    Route::get('faculties-export', [FacultyController::class,'export'])->name('faculties.export');
    Route::get('departments-import', [DepartmentController::class,'import'])->name('departments.import');
    Route::get('departments-export', [DepartmentController::class,'export'])->name('departments.export');
    Route::get('colleges-import', [CollegeController::class,'import'])->name('colleges.import');
    Route::get('colleges-export', [CollegeController::class,'export'])->name('colleges.export');
    Route::get('facultiesanddepartments-import', [FacultyDepartmentsController::class, 'import'])->name('facultiesanddepartments.import');
    Route::get('facultiesanddepartments-export', [FacultyDepartmentsController::class, 'export'])->name('facultiesanddepartments.export');  
    Route::get('facultiesandcolleges-import', [FacultyCollegesController::class, 'import'])->name('facultiesandcolleges.import');
    Route::get('facultiesandcolleges-export', [FacultyCollegesController::class, 'export'])->name('facultiesandcolleges.export');
    Route::get('facultiesandcarreers-import', [FacultyCarreersController::class, 'import'])->name('facultiesandcarreers.import');
    Route::get('facultiesandcarreers-export', [FacultyCarreersController::class, 'export'])->name('facultiesandcarreers.export');
    Route::get('departmentsandcarreers-import', [DepartmentCarreersController::class, 'import'])->name('departmentsandcarreers.import');
    Route::get('departmentsandcarreers-export', [DepartmentCarreersController::class, 'export'])->name('departmentsandcarreers.export');
    Route::get('carreers-import', [CarreerController::class,'import'])->name('carreers.import');
    Route::get('carreers-export', [CarreerController::class,'export'])->name('carreers.export');
    Route::get('curriculums-import', [CurriculumController::class, 'import'])->name('curriculums.import');
    Route::get('curriculums-export', [CurriculumController::class, 'export'])->name('curriculums.export');

  });

  

  

  



 

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

  Route::get('importds', [SubjectController::class,'import'])->name('subjects.import');
  Route::get('export', [SubjectController::class, 'export'])->name('subjects.export');

  