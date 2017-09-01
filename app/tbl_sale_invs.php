<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Auth;

class tbl_sale_invs extends Model
{
    //
    protected $table ='tbl_sale_invs';
    protected $fillable = [
    	'user_id',
        'toDate',
        'status',
        'invoid_code',
        'staff_id',
        'note',
        'zone_id',
        'takeout_staff_id'
    ];
	
	public function saleDeail(){
			
		return $this->hasMany('App\tbl_sale_details', 'sale_inv_id');
		//return $this->belongsToOne(Sub_menu::class);
		}
	
	public function getItem($id){
		$query=Tbl_item::where('id',$id)->get();
		$array_item=array();
		foreach($query as $obj){
				$array_item[0][$obj->id]=$obj->item_code;
				$array_item[1][$obj->id]=$obj->item_name;
			}
    	return $array_item;
	}
	public function getItem_stock($id){
		$query=Tbl_Item_Stock::where('item_id',$id)->get();
		$array_item_stock=array();
		foreach($query as $obj){
				$array_item_stock[$obj->inv_sale_id]=$obj->id;
			}
    	return $array_item_stock;
    }
    public static function getStaffName(){
        $query=Tbl_staffs::all();
        $array_staff=array();
        foreach($query as $obj){
            $array_staff[$obj->id]=$obj->staff_name;
        }
        return $array_staff;
    }
    public static function getZoneName(){
        $query=Tbl_zones::all();
        $array_zone=array();
        foreach($query as $obj){
            $array_zone[$obj->id]=$obj->zone;
        }
        return $array_zone;
    }

    public static function getSaleInvAll(){
    	return tbl_sale_invs::where('user_id',Auth::user()->id)->get()->count();
    }
    public static function getSaleInv(){
    	return tbl_sale_invs::where('user_id',Auth::user()->id)->orderBy('id','desc')
                            ->where('status','!=',2)->get();
    }
    public static function checkTakeOutStatus($sale_id){
    	return Tbl_Item_Stock::where('inv_sale_id',$sale_id)->get()->count();
    }

    public static function CountInvSale($status){
    	return tbl_sale_invs::where('status',$status)->get()->count();
    }
    public static function CountZone(){
        $query = DB::table('tbl_zones')
                ->select('tbl_sale_invs.zone_id','tbl_zones.zone',DB::raw('count(tbl_sale_invs.zone_id) as total'))
                ->join('tbl_sale_invs', 'tbl_sale_invs.zone_id', '=', 'tbl_zones.id')
                ->groupBy('tbl_sale_invs.zone_id')->get();
        $array=array();
        foreach($query as $obj){
            $array[]=array("name"=>"'".$obj->zone."'","y"=>intval($obj->total));
        }
        return json_encode($array);
        // return $query;
    }

    public static function itemRequestToday(){
        $todayDate = date("Y-m-d");
        $query = DB::table('tbl_items')
                ->select('tbl_items.item_code','tbl_staffs.staff_name','tbl_items.item_name','tbl_saleinv_details.qty')
                ->join('tbl_saleinv_details', 'tbl_saleinv_details.item_id', '=', 'tbl_items.id')
                ->join('tbl_sale_invs','tbl_sale_invs.id','=','tbl_saleinv_details.sale_inv_id')
                ->join('tbl_staffs','tbl_staffs.id','=','tbl_sale_invs.staff_id')
                ->orderBy('tbl_sale_invs.id','desc')
                ->where('tbl_sale_invs.status',0)
                ->where('tbl_sale_invs.toDate',$todayDate)->get();
        return $query;
    }

}
