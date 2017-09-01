<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ItemCategory;
use App\Tbl_Item_Stock;
use Illuminate\Support\Facades\DB;

class Tbl_item extends Model
{
    //
	protected $table='tbl_items';
	 
	protected $fillable= [
		'user_id',
		'item_category_id',
    	'item_code',
		'item_name',
		'item_model',
		'item_measure',
    	'photo',
    	'is_actived',
		'description'
    ];
    public function getItemDetail(){
    	return $this->hasMany('App\Tbl_item_detail', 'id');
    }
	
	public function getItemCateogry(){
		$query=ItemCategory::all();
		$array_category=array();
		foreach($query as $obj){
				$array_category[$obj->id]=$obj->category_name;
			}
    	return $array_category;
    }
	public static function getCountItemStock($item_id){
	//	$query=DB::table("tbl_item_stocks")->select(DB::Raw('sum(amount) as totalStock'))->where('item_id',$item_id)->where('status',0)->groupBy('item_id')->get();
		$query=Tbl_Item_Stock::where('item_id',$item_id)->get();
		$totalIn=0;
		$totalOut=0;
		$totalBroken=0;
		foreach($query as $obj){
			if($obj->status==0){
				$totalIn+=$obj->amount;
			}else if($obj->status==1){
				$totalOut+=$obj->amount;
			}else if($obj->status==2){
				$totalBroken+=$obj->amount;
			}
		}
		$total=$totalIn-($totalOut+$totalBroken);
		if($total){
			return $total;
		}else{
			return 0;
		}
    	
    }
	public function getItemStock(){
    	return $this->hasMany('App\Tbl_Item_Stock', 'item_id');
    }
}
