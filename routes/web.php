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

Route::group(['prefix'=>'/student'], function() {
  Route::get('/login', [
    'as' => 'student.login',
    'uses' => 'Auth\StudentLoginController@showLoginForm'
  ]);
  Route::post('/login', [
    'as' => '',
    'uses' => 'Auth\StudentLoginController@login'
  ]);
  Route::get('/register', [
    'as' => 'student.register',
    'uses' => 'Auth\RegisterStudentController@showRegistrationForm'
  ]);
  Route::post('/register', [
    'as' => '',
    'uses' => 'Auth\RegisterStudentController@register'
  ]);
  Route::get('/','StudentController@show');
});




//Teacher Routes
Route::group(['prefix'=>'/teacher'], function(){
  Route::get('/register', [
      'as' => 'teacher.register',
      'uses' => 'Auth\RegisterTeacherController@showRegistrationForm'
  ]);
  Route::post('/register', [
      'as' => '',
      'uses' => 'Auth\RegisterTeacherController@register'
  ]);
  Route::get('/login', [
      'as' => 'teacher.login',
      'uses' => 'Auth\TeacherLoginController@showLoginForm'
  ]);
  Route::post('/login', [
      'as' => '',
      'uses' => 'Auth\TeacherLoginController@login'
  ]);
  Route::get('/', [
      'as' => 'teacher',
      'uses' => 'TeacherController@show'
  ]);
  Route::get('/vm', [
      'as' => 'teacher.vm',
      'uses' => 'VMController@index'
  ]);
  Route::get('/vm/create', [
      'as' => 'teacher.vm.create',
      'uses' => 'VMController@create'
  ]);
  Route::post('/vm/store', [
      'as' => 'teacher.vm.store',
      'uses' => 'VMController@store'
  ]);
  Route::get('/vm/show/{name}', [
      'as' => 'teacher.vm.show.{name}',
      'uses' => 'VMController@show'
  ]);
  Route::post('/vm/update/{name}', [
    'as' => 'teacher.vm.update',
    'uses' => 'VMController@update'
  ]);
  Route::post('/vm/destroy/{name}', [
    'as' => 'teacher.vm.destroy',
    'uses' => 'VMController@destroy'
  ]);
  Route::get('/vm/upload', [
    'as' => 'teacher.vm.upload',
    'uses' => 'VMController@upload'
  ]);

  Route::get('/vm/{name}/edit', 'VMController@edit');
});


//logout
Route::post('/logout', [
  'as' => '/logout',
  'uses' => 'Auth\StudentLoginController@logout'
]);



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