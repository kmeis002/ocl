<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


use App\Models\Labs;
use App\Models\B2R;
use App\Models\Ctfs;
use App\Models\Classes;
use App\Models\Courses;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Enrolled;
use App\Models\Assignments;
use App\Models\Skills;
use App\Models\References;


class TeacherController extends Controller
{

	public function __construct(){

        $this->middleware('auth:teacher');

    }


    public function home(){

    	return view('teacher.home');

    }


    public function resourcesList($type){
        if($type === 'lab'){
            $list = Labs::all();
        }
        if($type === 'b2r'){
            $list = B2R::all();
        }
        if($type === 'ctf'){
            $list = Ctfs::all();
            $categories = DB::table('ctfs')->select('category')->distinct()->get();
        }

        if($type === 'lab' || $type === 'b2r'){
            return view('teacher.resources.list')->with(['list'=>$list, 'type' => $type]);
        }else if($type === 'ctf'){
            return view('teacher.resources.list')->with(['list'=>$list, 'type' => $type, 'categories' => $categories]);
        }
    }

    public function referencesList(){
        $refs = References::all();
        $skills = Skills::all();
        return view('teacher.classwork.references')->with(['refs' => $refs, 'skills' => $skills]);
    }

    public function skills(){
        $skills = Skills::all();
        return view('teacher.resources.skills')->with(['skills' => $skills]);
    }


    public function classesList($type){
        if($type === 'course'){
            $courseList = Courses::all();
            $classList = Classes::all();
            return view('teacher.classes.courselist')->with(['courseList'=>$courseList, 'classList'=>$classList, 'type' => $type]);
        }
        if($type === 'class'){
            $classList = Classes::all();
            $enrolledList = Enrolled::all();
            return view('teacher.classes.classlist')->with(['enrolledList'=>$enrolledList, 'classList'=>$classList, 'type' => $type]);
        }
    }

    public function assignmentsList(){
        $types = array('Lab', 'CTF', 'B2R');
        $classes = Classes::all();
        $assignments = Assignments::all();
        $students = Student::all();
        return view('teacher.classwork.assignments')->with(['types' => $types, 'classes' => $classes, 'assignments' => $assignments, 'students' => $students]);
    }

    public function students(){
        $students = Student::all();
        return view('teacher.accounts.students')->with(['students' => $students]);
    }

    public function teachers(){
        $teachers = Teacher::all();
        return view('teacher.accounts.teachers')->with(['teachers' => $teachers]);
    }

    public function getTeachers(){
        return DB::table('teachers')->pluck('name');
    }


    public function getStudents(){
        return DB::table('students')->select('name', 'first', 'last')->get();
    }


    public function editStudent(Request $request, $id){
        switch($request->method()){
            case 'POST':
                $request->validate([
                    'first' => ['required', 'string'],
                    'last' => ['required', 'string'],
                    'password' => ['nullable', 'string', 'min:8'],
                ]);

                $student = Student::find($id);
                $student->password = Hash::make($request->input('password'));
                $student->first = $request->input('first');
                $student->last = $request->input('last');

                $student->save();

                return redirect()->back();

            case 'GET':
                return Student::find($id);
        }
    }

    public function createStudent(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'first' => ['required', 'string'],
            'last' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        Student::create([
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password')),
            'first' => $request->input('first'),
            'last' => $request->input('last'),
            'raw_score' => '0',
            'mod_score' => '0',
        ]);

        return redirect()->back();
    }

    public function deleteStudent($id){
        $student = Student::find($id);
        $student->delete();
    }

    public function editTeacher(Request $request, $id){
        switch($request->method()){
            case 'POST':
                $request->validate([
                    'email' => ['required', 'email'],
                    'password' => ['nullable', 'string', 'min:8'],
                ]);

                $teacher = Teacher::find($id);
                $teacher->password = Hash::make($request->input('password'));
                $teacher->email = $request->input('email');

                $teacher->save();

                return redirect()->back();

            case 'GET':
                return Teacher::find($id);
        }
    }



    public function createTeacher(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        Teacher::create([
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password')),
            'email' => $request->input('email'),
            'api_token' => Str::random(60),
        ]);

        return redirect()->back();
    }

    public function deleteTeacher($id){
        $teacher = Teacher::find($id);
        $teacher->delete();
    }

    public function regenerateApiToken(Request $request, $id){
        $teacher = Teacher::find($id);
        $teacher->api_token = Str::random(60);
        $teacher->save();
    }

    public function completedAssignments($id){
        $student = Student::find($id);
        return $student->completedAssignments();
    }

    public function incompleteAssignments($id){
        $student = Student::find($id);
        return $student->incompleteAssignments();
    }


}
