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
Route::post('/hints/b2r', 'B2RHintController@reveal');

Route::post('/vms/status', 'VboxController@status');


//AJAX Teacher Testing Route (no auth!)


Route::get('/teacher/get/vbox/vminfo/{name}', 'VboxController@apiGetInfo');
Route::get('/teacher/get/vbox/interfaces', 'VboxController@apiGetHostInterfaces');
Route::get('/teacher/get/vbox/adapter/{name}', 'VboxController@apiGetBridgeAdapter');
Route::post('/teacher/set/vbox/network/{name}', 'VboxController@apiSetNetworkInterface');
Route::post('/teacher/set/vbox/bridged/{name}', 'VboxController@apiSetBridgedAdapter');
Route::post('/teacher/set/vbox/reset/{name}', 'VboxController@apiReset');
Route::post('/teacher/set/vbox/power/{name}', 'VboxController@apiPower');
Route::post('/teacher/set/vbox/unregister/{name}', 'VboxController@apiUnregister');
Route::post('/teacher/set/vbox/register/{name}', 'VboxController@apiRegister');

Route::get('/teacher/get/skills', 'SkillController@apiGet');
Route::get('/teacher/get/courses', 'CourseController@apiGet');
Route::get('/teacher/get/classes', 'ClassController@apiGetClasses');
Route::get('/teacher/get/enrolled/{id}', 'EnrollController@apiGetEnrolled');
Route::get('/teacher/get/b2r/{name}', 'B2RController@apiGetEditInfo');
Route::get('/teacher/get/all/b2r', 'B2RController@apiGetAll');
Route::get('/teacher/get/all/lab', 'LabController@apiGetAll');
Route::get('/teacher/get/all/ctf', 'CtfController@apiGetAll');
Route::get('/teacher/get/lab/{name}', 'LabController@apiGetEditInfo');
Route::get('/teacher/get/b2r/hints/{name}', 'B2RController@apiGetHints');
Route::get('/teacher/get/lab/hints/{name}', 'LabController@apiGetHints');
Route::get('/teacher/get/teachers', 'TeacherController@apiGetTeachers');
Route::get('/teacher/get/students', 'TeacherController@apiGetStudents');
Route::get('/teacher/get/assignment/levels/{id}', 'AssignmentController@apiGetLevels');
Route::get('/teacher/get/assignment/modelname/{id}', 'AssignmentController@apiGetModelName');



Route::post('/teacher/delete/b2r/hints/{id}', 'B2RHintController@apiDestroy');
Route::post('/teacher/delete/b2r/{name}', 'B2RController@apiDestroy');
Route::post('/teacher/delete/lab/{name}', 'LabController@apiDestroy');
Route::post('/teacher/delete/lab/hints/{id}', 'LabHintController@apiDestroy');
Route::post('/teacher/delete/lab/{name}/level/{id}', 'FlagController@apiLevelDestroy');
Route::post('/teacher/delete/vmskill/{name}', 'VMSkillController@apiDestroy');
Route::post('/teacher/delete/course/{name}', 'CourseController@apiDestroy');
Route::post('/teacher/delete/class/{id}', 'ClassController@apiDestroy');
Route::post('/teacher/delete/assignment/{id}', 'AssignmentController@apiDestroy');


Route::post('/teacher/create/b2r/{name}/hints', 'B2RHintController@apiCreate');
Route::post('/teacher/create/lab/{name}/hints', 'LabHintController@apiCreate');
Route::post('/teacher/create/lab/{name}/level', 'FlagController@apiLevelCreate');
Route::post('/teacher/create/vmskill/{name}', 'VMSkillController@apiCreate');
Route::post('/teacher/create/b2r', 'B2RController@apiCreate');
Route::post('/teacher/create/course', 'CourseController@apiCreate');
Route::post('/teacher/create/class', 'ClassController@apiCreate');

Route::post('/teacher/enroll/{id}', 'EnrollController@apiEnroll');
Route::post('/teacher/unenroll/{id}', 'EnrollController@apiUnenroll');


Route::post('/teacher/update/b2r/{name}/hints', 'B2RHintController@apiUpdate');
Route::post('/teacher/update/lab/{name}/hints', 'LabHintController@apiUpdate');
Route::post('/teacher/update/assignment/{id}', 'AssignmentController@apiUpdate');
//Route::middleware('auth:api')->post('/chunk_upload', 'ChunkUploadController@chunkStore');
Route::post('/teacher/upload/chunkupload', 'ChunkUploadController@chunkStore');


Route::post('/teacher/delete/vm/file/{name}', 'VMController@apiDeleteOva');


Route::get('/test/{name}', 'ChunkUploadController@test');