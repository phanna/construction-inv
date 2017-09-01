<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_department extends Model
{
    //
	protected $table='tbl_department';

	protected $fillable = [
		'department_name'
	];
	
	public function getStaffs(){	
		return $this->hasMany('App\Tbl_staffs', 'department_id');
	}
}
