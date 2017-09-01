<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_suppliers extends Model
{
	protected $table = 'tbl_suppliers';
	protected $fillable = [
		'company_name',
		'seller',
		'phone',
		'address'
	];
}