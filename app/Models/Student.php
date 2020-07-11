<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

    public function enrolledCount(){
        return $this->enrolled()->get()->count();
    }

    public function classAssignments($i){
        return $this->enrolled()->get()[$i]->class->assignments;
        
    }

}
