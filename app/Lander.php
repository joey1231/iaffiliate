<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lander extends Model
{
	use SoftDeletes;
    /**
    * lander has many lander url
    * return array of lander url
    */
    public function urls(){
    	return $this->hasMany(LanderUrl::class);
    }
}
