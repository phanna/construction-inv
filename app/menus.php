<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class menus extends Model
{
	
	protected $table_menu = 'tbl_menus';
	protected $table_sub_menu = 'tbl_sub_menus';
    //select menu
	public static function menu_fn(){
		$tbl_menus = DB::table('tbl_menus')->get();
		return $tbl_menus;
	
	}
	//parent and child 
	 public static function parent()
    {
        return $this->belongsTo('tbl_menus', 'id');
    }

    public static function children()
    {
        return $this->hasMany('tbl_sub_menus', 'menu_id');
    }

   
}
