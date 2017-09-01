<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_Role extends Model
{
    //
    protected $table = 'tbl_roles';

    public function getUser(){
    	return $this->hasMany('App\User', 'role_id');
    }
}
