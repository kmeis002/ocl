<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Labs;
use App\Models\B2RHints;
use App\Models\LabHints;
use App\Models\LabsAssigned;
use App\Models\B2RsAssigned;
use App\Models\CtfsAssigned;

class Student extends Authenticatable
{
    use Notifiable;

    protected $guard = 'students';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'first', 'last', 'raw_score', 'mod_score',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute(){
        return $this->first. ' ' . $this->last;
    }
    
    public function enrolled(){
        return $this->hasMany('App\Models\Enrolled', 'student', 'name');
    }

    public function hintsUsed(){
        return $this->hasMany('App\Models\HintsUsed', 'student', 'name');
    }

    public function B2RFlags(){
        return $this->hasMany('App\Models\CompletedB2RFlags', 'student', 'name');
    }

    public function LabFlags(){
        return $this->hasMany('App\Models\CompletedLabFlags', 'student', 'name');
    }

    public function CtfFlags(){
        return $this->hasMany('App\Models\CompletedCtfs', 'student', 'name');
    }

    public function score(){
        return $this->hasMany('App\Models\Score', 'student', 'name');
    }

    public function enrolledCount(){
        return $this->enrolled()->get()->count();
    }

    public function classAssignments($i){
        return $this->enrolled()->get()[$i]->class->assignments;
        
    }

    public function allAssignments(){
        if($this->enrolledCount() > 0){
            $out = $this->classAssignments(0);
            for($i=1; $i<$this->enrolledCount(); $i++){
                $out = $out->merge($this->classAssignments($i));
            }
            return $out;
        }

        return collect();
    }

    public function labsAssigned(){
        return $this->allAssignments()->where('prefix', '=', 'Lab');
    }

    public function b2rsAssigned(){
        return $this->allAssignments()->where('prefix', '=', 'B2R');
    }

    public function ctfsAssigned(){
        return $this->allAssignments()->where('prefix', '=', 'CTF');
    }

    public function completedAssignments(){
        $all = $this->allAssignments();

        $out = collect([]);

        foreach($all as $a){
            if($this->checkAssignment($a)){
                $out->push($a);
            }
        }

        return $out;
    }

    public function incompleteAssignments(){
        $all = $this->allAssignments();

        $out = collect([]);

        foreach($all as $a){
            if(!$this->checkAssignment($a)){
                $out->push($a);
            }
        }

        return $out;
    }

    public function checkAssignment($assignment){
        $type = $assignment->prefix;

        if($type === 'Lab'){
           return $this->checkLab($assignment);
        }
        else if($type === 'CTF'){
           return $this->checkCTF($assignment);
        }
        else if($type === 'B2R'){
           return $this->checkB2R($assignment);
        }

        return false;
        
    }

    private function checkLab($lab){
        $start_level = $lab->lab->start_level;
        $end_level = $lab->lab->end_level;

        $flags = $this->LabFlags()->where('lab_name', '=', $lab->lab->lab_name)->get();

        for($i=$start_level; $i<=$end_level; $i++){
            if($flags->where('level', '=', $i)->isEmpty()){
                return false;
            }
        }
        return true;
    }


    private function checkCTF($ctf){
        return $this->CtfFlags()->where('ctf_name', '=', $ctf->ctf->ctf_name)->get()->isNotEmpty();
    }

    private function checkB2R($b2r){
        $user = $b2r->b2r->user;
        $root = $b2r->b2r->root;
        $flags = $this->B2RFlags()->where('b2r_name', '=', $b2r->b2r->b2r_name)->get();

        return ($flags->where('is_root', '=', '0')->isNotEmpty() == $user && $flags->where('is_root', '=', '1')->isNotEmpty() == $root);
    }

    //array of lab names assigned
    public function labArray(){
        $labs = $this->labsAssigned();
        $out = array();

        foreach($labs as $l){
            $name = LabsAssigned::find($l->model_id)->lab_name;
            array_push($out, $name);
        }

        return $out;
    }

    public function b2rArray(){
        $b2rs = $this->b2rsAssigned();
        $out = array();

        foreach($b2rs as $b){
            $name = B2RsAssigned::find($b->model_id)->b2r_name;
            array_push($out, $name);
        }

        return $out;
    }

    public function ctfArray(){
        $ctfs = $this->ctfsAssigned();
        $out = array();

        foreach($ctfs as $c){
            $name = CtfsAssigned::find($c->model_id)->ctf_name;
            array_push($out, $name);
        }

        return $out;
    }

    public function B2RCheck($name){
        $out = array();
        $root = $this->B2RFlags()->where([['b2r_name', '=', $name],['is_root', '=', '1']])->count();
        $user = $this->B2RFlags()->where([['b2r_name', '=', $name],['is_root', '=', '0']])->count();

        array_push($out, $user);
        array_push($out, $root);

        return $out;
    }


    public function labCheck($name){
        $out = array();

        $levelCount = Labs::find($name)->countLevels();

        for($i = 1; $i <= $levelCount; $i++){
            $levelCheck = $this->LabFlags()->where([['lab_name', '=', $name], ['level', '=', $i]])->count();
            array_push($out, $levelCheck);
        }

        return $out;
    }

    public function ctfCheck($name){
        return ($this->CtfFlags()->where('ctf_name', '=', $name)->count() === 1);
    }

    public function rootOwns(){
        $owns = $this->B2RFlags()->where([['is_root', '=', '1']])->count();
        return $owns;
    }

    public function userOwns(){
        $owns = $this->B2RFlags()->where([['is_root', '=', '0']])->count();
        return $owns;
    }

    public function levelOwns(){
        return $this->LabFlags()->count();
    }


    public function HintsCheck($name){
        return $this->HintsUsed()->where('machine_name', '=', $name)->get();
    }


    public static function boot() {
        parent::boot();

        //Delete event to delete entries in other tables/files
        static::deleting(function($Student) { 
            //Delete hasMany relations
             $Student->HintsUsed()->delete();
             $Student->enrolled()->delete();
             $Student->B2RFlags()->delete();
             $Student->LabFlags()->delete();
             $Student->CTFFlags()->delete();
             $Student->score()->delete();
        });
    }

}
