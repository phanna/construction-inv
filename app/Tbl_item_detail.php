<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_item_detail extends Model
{
    //
	protected $table='tbl_item_details';
	
	protected $fillable= [
    	'item_id',
    	'unit_price',
		'inventory_type',
		
    ];

    public function getItem(){
    	return $this->belongsTo('App\Tbl_item', 'item_id');
    }

}
