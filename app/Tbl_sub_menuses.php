<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_sub_menuses extends Model
{
    //
	protected $table='tbl_sub_menuses';
	
	public function menus(){
		return $this->belongsTo('App\Tbl_menuses', 'id');
		//return $this->hasMany(Menu::class);
	}
}
