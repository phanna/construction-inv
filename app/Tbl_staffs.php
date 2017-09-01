<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Tbl_staffs extends Model
{
    //
	protected $table='tbl_staffs';

	protected $fillable = [
		'staff_name',
		'phone_number',
		'gender',
		'position',
		'type',
		'staff_group'
	];
	
    
	public static function staffId($id){
		return Tbl_staffs::where('id',$id)->get();
	}
}
