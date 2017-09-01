<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_itemUnit extends Model
{
	protected $table = 'tbl_units';
	protected $fillable = [
		'name'
	];
}