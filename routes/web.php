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
  Route::get('/home', 'PageTest@teacherHome');
  Route::get('/list/{type}', 'PageTest@teacherList');
  Route::post('/edit/b2r/{name}', 'B2RController@update');
  Route::post('/edit/b2r/hints/{name}', 'B2RHintController@test');
  Route::post('/create/b2r', 'B2RController@create');
  Route::post('/create/lab', 'LabController@create');
  Route::post('/edit/lab/{name}', 'LabController@update');
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
