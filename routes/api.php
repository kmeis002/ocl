<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('/vbox/all', 'VboxController@showAllVMs');

Route::get('/vbox/test', 'VboxController@test');

Route::post('/mqtt/publish', 'VMVisorController@MqttTest');

Route::post('/flag/rotate', 'FlagController@rotateFlag');





//AJAX Student Routes
Route::post('/hints/lab', 'LabHintController@reveal');



//AJAX Teacher Testing Route (no auth!)

Route::group(['prefix'=>'/teacher'], function() {
	Route::group(['prefix' => '/get'], function(){
		Route::get('/vbox/vminfo/{name}', 'VboxController@apiGetInfo');
		Route::get('/vbox/interfaces', 'VboxController@apiGetHostInterfaces');
		Route::get('/vbox/adapter/{name}', 'VboxController@apiGetBridgeAdapter');
		Route::get('/vbox/vminfo/{name}', 'VboxController@apiGetInfo');
		Route::get('/vbox/interfaces', 'VboxController@apiGetHostInterfaces');
		Route::get('/vbox/adapter/{name}', 'VboxController@apiGetBridgeAdapter');
		Route::get('/skills', 'SkillController@apiGet');
		Route::get('/courses', 'CourseController@apiGet');
		Route::get('/classes', 'ClassController@apiGetClasses');
		Route::get('/enrolled/{id}', 'EnrollController@apiGetEnrolled');
		Route::get('/b2r/{name}', 'B2RController@apiGetEditInfo');
		Route::get('/all/b2r', 'B2RController@apiGetAll');
		Route::get('/all/lab', 'LabController@apiGetAll');
		Route::get('/all/ctf', 'CtfController@apiGetAll');
		Route::get('/lab/{name}', 'LabController@apiGetEditInfo');
		Route::get('/b2r/hints/{name}', 'B2RController@apiGetHints');
		Route::get('/lab/hints/{name}', 'LabController@apiGetHints');
		Route::get('/teachers', 'TeacherController@apiGetTeachers');
		Route::get('/students', 'TeacherController@apiGetStudents');
		Route::get('/assignment/levels/{id}', 'AssignmentController@apiGetLevels');
		Route::get('/assignment/modelname/{id}', 'AssignmentController@apiGetModelName');
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
		Route::post('/b2r/hints/{id}', 'B2RHintController@apiDestroy');
		Route::post('/b2r/{name}', 'B2RController@apiDestroy');
		Route::post('/lab/{name}', 'LabController@apiDestroy');
		Route::post('/lab/hints/{id}', 'LabHintController@apiDestroy');
		Route::post('/lab/{name}/level/{id}', 'FlagController@apiLevelDestroy');
		Route::post('/vmskill/{name}', 'VMSkillController@apiDestroy');
		Route::post('/course/{name}', 'CourseController@apiDestroy');
		Route::post('/class/{id}', 'ClassController@apiDestroy');
		Route::post('/assignment/{id}', 'AssignmentController@apiDestroy');
		Route::post('/vm/file/{name}', 'VMController@apiDeleteOva');
	});

	Route::group(['prefix' => '/create'], function(){
		Route::post('/b2r/{name}/hints', 'B2RHintController@apiCreate');
		Route::post('/lab/{name}/hints', 'LabHintController@apiCreate');
		Route::post('/lab/{name}/level', 'FlagController@apiLevelCreate');
		Route::post('/vmskill/{name}', 'VMSkillController@apiCreate');
		//Route::post('/b2r', 'B2RController@apiCreate');
		//Route::post('/lab', 'LabController@apiCreate');
		Route::post('/course', 'CourseController@apiCreate');
		Route::post('/class', 'ClassController@apiCreate');
	});

	Route::group(['prefix' => '/update'], function(){
		Route::post('/b2r/{name}/hints', 'B2RHintController@apiUpdate');
		Route::post('/lab/{name}/hints', 'LabHintController@apiUpdate');
		Route::post('/assignment/{id}', 'AssignmentController@apiUpdate');
	});
	
	Route::post('/enroll/{id}', 'EnrollController@apiEnroll');
	Route::post('/unenroll/{id}', 'EnrollController@apiUnenroll');
	Route::post('/upload/chunkupload', 'ChunkUploadController@chunkStore');

});


Route::group(['prefix'=>'/student', 'middleware'=>'auth:student'], function() {
	Route::group(['prefix'=>'/get'], function() {
		
		Route::get('/lab/{name}', 'LabController@apiStudentGet');
		Route::post('/hint/b2r/{name}', 'B2RHintController@reveal');
		Route::post('/hint/lab/{name}', 'LabHintController@reveal');
	});

});








