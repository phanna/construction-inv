<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_sale_details extends Model
{
    //
    protected $table = 'tbl_saleinv_details';
	protected $fillable = [
    	'sale_inv_id',
        'item_id',
        'qty',
        'unit_price'
    ];
	
	public function saleInv(){
		return $this->belongsTo('App\tbl_sale_invs', 'id');
		//return $this->hasMany(Menu::class);
	}
}
