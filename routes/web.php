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

Route::get('/', function () {
    return view('login');
});


//Student Routes

Route::group(['middleware' => 'auth:student', 'prefix'=>'/student'], function() {

  Route::get('/','StudentController@show');
  Route::get('/list/resources/{type}', 'StudentController@listResources');

  Route::group(['prefix'=>'/get'], function() {
    Route::get('/b2r/{name}', 'B2RController@studentGet');
    Route::get('/lab/{name}', 'LabController@studentGet');
    Route::post('/hint/b2r/{name}', 'B2RHintController@reveal');
    Route::post('/hint/lab/{name}', 'LabHintController@reveal');
  });

  Route::group(['prefix' => '/submit'], function(){
    Route::post('/flag/{name}', 'FlagController@submitFlag');
  });

 
});

  Route::get('/student/login', [
    'as' => 'student.login',
    'uses' => 'Auth\StudentLoginController@showLoginForm'
  ]);

  Route::post('/student/login', [
    'as' => '',
    'uses' => 'Auth\StudentLoginController@login'
  ]);

  //logout
  Route::get('/student/logout', [
    'as' => '/logout',
    'uses' => 'Auth\StudentLoginController@logout'
  ]);
//Teacher Routes
Route::group(['prefix'=>'/teacher'], function(){
  Route::get('/home', 'PageTest@teacherHome');
  Route::get('/accounts/students', 'TeacherController@students');
  Route::get('/accounts/teachers', 'TeacherController@teachers');
  Route::get('/resources/list/{type}', 'TeacherController@resourcesList');
  Route::get('/classes/list/{type}', 'TeacherController@classesList');
  Route::get('/classwork/assignments', 'TeacherController@assignmentsList');
  Route::post('/edit/b2r/{name}', 'B2RController@update');
  Route::post('/edit/b2r/hints/{name}', 'B2RHintController@test');
  Route::post('/create/b2r', 'B2RController@create');
  Route::post('/create/lab', 'LabController@create');
  Route::post('/create/assignment', 'AssignmentController@create');
  Route::post('/edit/lab/{name}', 'LabController@update');
  Route::get('/accounts/edit/student/{id}', 'TeacherController@editStudent');
  Route::post('/accounts/edit/student/{id}', 'TeacherController@editStudent');
  Route::post('/accounts/create/student', 'TeacherController@createStudent');
  Route::post('/accounts/delete/student/{id}', 'TeacherController@deleteStudent');
  Route::get('/accounts/edit/teacher/{id}', 'TeacherController@editTeacher');
  Route::post('/accounts/edit/teacher/{id}', 'TeacherController@editTeacher');
  Route::post('/accounts/create/teacher', 'TeacherController@createTeacher');
  Route::post('/accounts/delete/teacher/{id}', 'TeacherController@deleteTeacher');
  Route::post('/accounts/teacher/api_regen/{id}', 'TeacherController@regenerateApiToken');
});







Route::get('/test', function(){
  return view('student.home');
});


Route::get('/test/lab', function(){
  return view('student.lab');
});

Route::get('/presenter/lab/{name}', 'PageTest@labtest');
Route::get('/presenter/b2r/{name}', 'PageTest@b2rtest');
Route::get('/presenter/listmachines', 'PageTest@machineList');
Route::get('/presenter/list/{type}', 'PageTest@list');
Route::get('/presenter/shuffletest', 'PageTest@shuffletest');
Route::get('/presenter/home', 'PageTest@home');
