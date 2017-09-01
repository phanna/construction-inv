<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Tbl_Post extends Model
{
    //
	protected $table='tbl_posts';
	protected $fillable= [
		'user_id',
		'title'
	];
	 public function getUser($id)
    {
		$query=User::where('id',$id)->get();
        return $query[0]->name;
    }

}
