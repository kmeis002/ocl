<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Teacher extends Authenticatable
{
    use Notifiable;

    protected $guard = 'teachers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token',
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

    public function classes(){
        return $this->hasMany('App\Models\Classes', 'teacher', 'name');
    }


    public static function boot() {
        parent::boot();

        //Delete event to delete entries in other tables/files
        static::deleting(function($teacher) { 
            //Delete hasMany relations
            $classes = $teacher->classes()->get();

            foreach($classes as $c){
                $c->delete();
            }
        });
    }

}
