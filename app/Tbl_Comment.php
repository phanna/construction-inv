<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_Comment extends Model
{
    //
	protected $table='tbl_comments';
	protected $fillable= [
		'user_id',
		'post_id',
		'comment'
	];

}
