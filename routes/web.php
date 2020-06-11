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
    return view('welcome');
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
      'uses' => 'VMController@show'
  ]);
  Route::post('/vm/upload', [
      'as' => 'teacher.vm.upload',
      'uses' => 'VMController@upload'
  ]);
});



//logout
Route::post('/logout', [
  'as' => '/logout',
  'uses' => 'Auth\StudentLoginController@logout'
]);




