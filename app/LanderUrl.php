<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Libraries\Voluum;

class LanderUrl extends Model
{
    use SoftDeletes;

    public function lander(){
    	return $this->belongsTo(Lander::class);
    }
    public function updateUrlVoluumLander(){

    	$data = Voluum::updateLanderUrl($this->lander->lander_id, $this->lander_url,$this->lander->lander_name);
    	return $data;
    }
}
