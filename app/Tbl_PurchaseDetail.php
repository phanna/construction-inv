<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_PurchaseDetail extends Model
{
    //
    protected $table = 'tbl_purchase_detail';

    protected $fillable=[
    	'purchase_id',
    	'item_id',
    	'qty',
    	'unit_price'
    ];
}
