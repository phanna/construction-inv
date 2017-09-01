<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_Item_Stock extends Model
{
    //
	protected $table='tbl_item_stocks';
	 
	protected $fillable= [
		'item_id',
		'amount',
		'status',
		'inv_sale_id',
		'inv_purchase_id',
		'unit_price',
		'purchase_date'
    ];
	
	public function getItem(){
    	return $this->belongsTo('App\Tbl_item', 'id');
    }
}
