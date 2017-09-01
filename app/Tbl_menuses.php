<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_menuses extends Model
{
    //
	//protected $table='tbl_menuses';
	public function subMenus(){
			
		return $this->hasMany('App\Tbl_sub_menuses', 'menu_id');
		//return $this->belongsToOne(Sub_menu::class);
		}
	
}
