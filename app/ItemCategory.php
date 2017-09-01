<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ItemCategory extends Model
{
    //
	protected $table='tbl_categories';
	protected $fillable= [
		'id',
		'category_name'
	];

	public function getItemList(){
    	return $this->hasMany('App\Tbl_item', 'item_category_id');
    }

    public function getItemNameHasStock($item_id){
    	$getItemHasStock = DB::table('tbl_items')
                ->select('tbl_item_stocks.*','tbl_items.*')
                ->join('tbl_item_stocks','tbl_item_stocks.item_id', '=', 'tbl_items.id')
                ->groupBy('item_id')
                ->where('tbl_item_stocks.item_id',$item_id)->get();
        return $getItemHasStock;
    }

}
