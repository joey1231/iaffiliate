<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
	protected $fillable=[
		'advertiserCost',
        'clicks',
        'conversions',
        'cost',
        'cpv',
        'cr',
        'ctr',
        'customVariable1',
        'cv',
        'epc',
        'epv',
        'errors',
        'hour',
        'ictr',
        'impressions',
        'profit',
        'revenue',
        'roi',
        'visits',
        'campaign_id',
        'zeropark_campaign_id',
            // 0 not live - 1 curently live
        'status',
        'ban_status'
	];
	const BLACK_LIST= 1;
	const GREY_LIST =2;
	const WHITE_LIST =3;
    public static function  runAlgo($cost,$roi){
    	//black list and grey list
    	if($cost >= 1){
    		// white list algo
    		if($cost >= 3){
    			if($roi > 0){
    				return self::WHITE_LIST;
    			}	
    		}
    		// black list and grey list
    		if($roi < 0){
    				if($roi > -20){
    					return self::GREY_LIST;
    				}else{
    					return self::BLACK_LIST;
    				}
    		}
    	}
    	return null;
    }
}
