<?php

use Illuminate\Support\Facades\Route;

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

//Auth Routes
Route::get('/student/login', [
  'as' => 'student.login',
  'uses' => 'Auth\StudentLoginController@showLoginForm']
);

Route::get('/teacher/login', [
  'as' => 'teacher.login',
  'uses' => 'Auth\TeacherLoginController@showLoginForm']
);

Route::post('/teacher/login', 'Auth\TeacherLoginController@login');
Route::post('/student/login', 'Auth\StudentLoginController@login');
Route::get('/student/logout', [
  'as' => 'student.logout',
  'uses' => 'Auth\StudentLoginController@logout'
]);

Route::get('/teacher/logout', [
  'as' => 'teacher.logout',
  'uses' => 'Auth\TeacherLoginController@logout'
]);
  
//Student Routes
Route::group(['middleware' => 'auth:student', 'prefix'=>'/student'], function() {

  Route::get('/home','StudentController@show');
  Route::get('/list/resources/{type}', 'StudentController@listResources');
  Route::get('/list/references', 'StudentController@listReferences');
  Route::get('/reference/{id}', 'StudentController@showReference');

  Route::group(['prefix'=>'/get'], function() {
    Route::get('/b2r/{name}', 'B2RController@studentGet');
    Route::get('/lab/{name}', 'LabController@studentGet');
    Route::post('/hint/b2r/{name}', 'B2RHintController@reveal');
    Route::post('/hint/lab/{name}', 'LabHintController@reveal');
  });

  Route::group(['prefix' => '/submit'], function(){
    Route::post('/flag/{name}', 'FlagController@submitFlag');
  });

  Route::get('/dashboard', 'StudentController@dashboard');
  Route::get('/leaderboards', 'StudentController@leaderboards');
});


//Teacher Routes
Route::group(['middleware' => 'auth:teacher', 'prefix'=>'/teacher'], function(){
  Route::get('/home', 'TeacherController@home');
  Route::group(['prefix' => '/accounts'], function(){
    Route::get('/students', 'TeacherController@students');
    Route::get('/teachers', 'TeacherController@teachers');
    Route::get('/edit/student/{id}', 'TeacherController@editStudent');
    Route::post('/edit/student/{id}', 'TeacherController@editStudent');
    Route::post('/create/student', 'TeacherController@createStudent');
    Route::post('/delete/student/{id}', 'TeacherController@deleteStudent');
    Route::get('/edit/teacher/{id}', 'TeacherController@editTeacher');
    Route::post('/edit/teacher/{id}', 'TeacherController@editTeacher');
    Route::post('/create/teacher', 'TeacherController@createTeacher');
    Route::post('/delete/teacher/{id}', 'TeacherController@deleteTeacher');
    Route::post('/teacher/api_regen/{id}', 'TeacherController@regenerateApiToken');
  });

  Route::group(['prefix' => '/create'], function(){
    Route::post('/b2r', 'B2RController@create');
    Route::post('/lab', 'LabController@create');
    Route::post('/ctf', 'CtfController@create');
    Route::post('/skill', 'SkillController@create');
    Route::post('/assignment', 'AssignmentController@create');
    Route::post('/b2r/{name}/hints', 'B2RHintController@create');
    Route::post('/lab/{name}/hints', 'LabHintController@create');
    Route::post('/lab/{name}/level', 'FlagController@apiLevelCreate');
    Route::post('/vmskill/{name}', 'VMSkillController@apiCreate');
    Route::post('/course', 'CourseController@apiCreate');
    Route::post('/class', 'ClassController@apiCreate');
    Route::post('/reference', 'ReferenceController@create');
    Route::post('/section/{id}', 'ReferenceController@createSection');
    Route::post('/reference/skill/{id}', 'ReferenceController@addSkill');
  });

  Route::group(['prefix' => '/get'], function(){
    Route::get('/vbox/vminfo/{name}', 'VboxController@apiGetInfo');
    Route::get('/vbox/interfaces', 'VboxController@apiGetHostInterfaces');
    Route::get('/vbox/adapter/{name}', 'VboxController@apiGetBridgeAdapter');
    Route::get('/vbox/vminfo/{name}', 'VboxController@apiGetInfo');
    Route::get('/vbox/interfaces', 'VboxController@apiGetHostInterfaces');
    Route::get('/vbox/adapter/{name}', 'VboxController@apiGetBridgeAdapter');
    Route::get('/skills', 'SkillController@get');
    Route::get('/student/{id}/assignments/completed', 'TeacherController@completedAssignments');
    Route::get('/student/{id}/assignments/incomplete', 'TeacherController@incompleteAssignments');
    Route::get('/courses', 'CourseController@apiGet');
    Route::get('/classes', 'ClassController@apiGetClasses');
    Route::get('/enrolled/{id}', 'EnrollController@apiGetEnrolled');
    Route::get('/b2r/{name}', 'B2RController@getEditInfo');
    Route::get('/all/b2r', 'B2RController@getAll');
    Route::get('/all/lab', 'LabController@getAll');
    Route::get('/all/ctf', 'CtfController@apiGetAll');
    Route::get('/lab/{name}', 'LabController@getEditInfo');
    Route::get('/ctf/{name}', 'CtfController@getEditInfo');
    Route::get('/b2r/hints/{name}', 'B2RController@getHints');
    Route::get('/lab/hints/{name}', 'LabController@getHints');
    Route::get('/teachers', 'TeacherController@getTeachers');
    Route::get('/students', 'TeacherController@getStudents');
    Route::get('/assignment/levels/{id}', 'AssignmentController@apiGetLevels');
    Route::get('/assignment/modelname/{id}', 'AssignmentController@apiGetModelName');
    Route::get('/sections/name/{id}', 'ReferenceController@getSectionNames');
    Route::get('/section/{id}', 'ReferenceController@getSection');
    Route::get('/reference/skills/{id}', 'ReferenceController@getSkills');
  });

  Route::group(['prefix' => '/set/vbox'], function(){
    Route::post('/network/{name}', 'VboxController@apiSetNetworkInterface');
    Route::post('/bridged/{name}', 'VboxController@apiSetBridgedAdapter');
    Route::post('/reset/{name}', 'VboxController@apiReset');
    Route::post('/power/{name}', 'VboxController@apiPower');
    Route::post('/unregister/{name}', 'VboxController@apiUnregister');
    Route::post('/register/{name}', 'VboxController@apiRegister');
    Route::post('/network/{name}', 'VboxController@apiSetNetworkInterface');
    Route::post('/bridged/{name}', 'VboxController@apiSetBridgedAdapter');
    Route::post('/reset/{name}', 'VboxController@apiReset');
    Route::post('/power/{name}', 'VboxController@apiPower');
    Route::post('/unregister/{name}', 'VboxController@apiUnregister');
    Route::post('/register/{name}', 'VboxController@apiRegister');
  });

  Route::group(['prefix' => '/delete'], function(){
    Route::post('/b2r/hints/{id}', 'B2RHintController@destroy');
    Route::post('/b2r/{name}', 'B2RController@destroy');
    Route::post('/lab/{name}', 'LabController@destroy');
    Route::post('/skill/{id}', 'SkillController@delete');
    Route::post('/ctf/zip/{filename}', 'CtfController@deleteZip');
    Route::post('/lab/hints/{id}', 'LabHintController@destroy');
    Route::post('/lab/{name}/level/{id}', 'FlagController@apiLevelDestroy');
    Route::post('/vmskill/{name}', 'VMSkillController@apiDestroy');
    Route::post('/course/{name}', 'CourseController@apiDestroy');
    Route::post('/class/{id}', 'ClassController@apiDestroy');
    Route::post('/assignment/{id}', 'AssignmentController@apiDestroy');
    Route::post('/vm/file/{name}', 'VMController@apiDeleteOva');
    Route::post('/section/{id}', 'ReferenceController@deleteSection');
    Route::post('/reference/{id}', 'ReferenceController@delete');
    Route::post('/reference/skills/{id}', 'ReferenceController@deleteSkill');
  });

  Route::group(['prefix' => '/update'], function(){
    Route::post('/b2r/{name}/hints', 'B2RHintController@update');
    Route::post('/lab/{name}/hints', 'LabHintController@update');
    Route::post('/assignment/{id}', 'AssignmentController@apiUpdate');
    Route::post('/section/{id}', 'ReferenceController@updateSection');
  });

  Route::group(['prefix' => '/edit'], function(){
      Route::post('/b2r/{name}', 'B2RController@update');
      Route::post('/b2r/hints/{name}', 'B2RHintController@test');
      Route::post('/lab/{name}', 'LabController@update');
      Route::post('/ctf/{name}', 'CtfController@update');
  });
  
  Route::post('/enroll/{id}', 'EnrollController@apiEnroll');
  Route::post('/unenroll/{id}', 'EnrollController@apiUnenroll');
  Route::post('/upload/chunkupload', 'ChunkUploadController@chunkStore');
  Route::post('/upload/zipupload', 'ChunkUploadController@zipStore');
  Route::post('/classwork/upload/image', 'CkEditorController@upload');

  Route::get('/resources/list/{type}', 'TeacherController@resourcesList');
  Route::get('/resources/skills', 'TeacherController@skills');
  Route::get('/classes/list/{type}', 'TeacherController@classesList');

  Route::get('/classwork/assignments', 'TeacherController@assignmentsList');
  Route::get('/classwork/references', 'TeacherController@referencesList');
});

