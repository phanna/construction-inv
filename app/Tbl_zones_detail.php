<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_zones_detail extends Model
{
    //
    protected $table = 'tbl_zones_detail';
    protected $fillable = [
    	'zone_id','item_id','qty'
    ];

    public static function createZoneItem($data){
    	return Tbl_zones_detail::create($data);
    }
    public static function updateZoneItem($id,$data){
        return Tbl_zones_detail::where('id',$id)->update($data);
    }
    public function ZoneName(){
    	$arrayzone = array();
    	$zones = Tbl_zones::get();
    	foreach($zones as $zone){
    		$arrayzone[$zone->id]=$zone->zone;
    	}
    	return $arrayzone;
    }
    public function ItemName(){
    	$arrayItem = array();
    	$items = Tbl_item::get();
    	foreach($items as $item){
    		$arrayItem[$item->id]=$item->item_name;
    	}
    	return $arrayItem;
    }
}
