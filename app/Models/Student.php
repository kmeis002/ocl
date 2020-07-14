<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Labs;
use App\Models\B2RHints;
use App\Models\LabHints;

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
        'name', 'password', 'first', 'last', 'total_score',
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


    public function enrolledCount(){
        return $this->enrolled()->get()->count();
    }

    public function classAssignments($i){
        return $this->enrolled()->get()[$i]->class->assignments;
        
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

}
