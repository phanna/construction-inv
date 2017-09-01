<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $fillable = [
        'name','role_id','dept_id', 'email', 'password','position','telephone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getRole(){
        return $this->belongsTo('App\Tbl_Role', 'id');
    }

    public function getRoleName(){
        $query=Tbl_Role::all();
        $array_role=array();
        foreach($query as $obj){
                $array_role[$obj->id]=$obj->role_name;
            }
        return $array_role;
    }
    public function getDeptName(){
        $query=Tbl_department::all();
        $array_dept=array();
        foreach($query as $obj){
                $array_dept[$obj->id]=$obj->department_name;
            }
        return $array_dept;
    }
}

