<?php

namespace App\Libraries;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Carbon\Carbon;
class Voluum
{

	const VOLUUM_TIME_FORMAT = 'Y-m-d\TH:i:s\Z';
	const TIMEZONE = 'UTC';
    public static function obtainAuthToken (){
		
		//Use Basic Auth to retrieve the Auth Token for further requests
		$client = new Client();
		$res = $client->get('https://security.voluum.com/login', [
    		'auth' => [
        		env('VOLUUM_EMAIL'), 
        		env('VOLUUM_PASSWORD'),
    		]
		]);
		$data = json_decode($res->getBody(), true);
		if ( $data['loggedIn'] && isset($data['token']) ){
			return $data['token'];
		}
		return null;
	}
	public static function updateLanderUrl($lander_id,$url,$name){
		$token = self::obtainAuthToken();
		if(is_null($token)){
			throw new Exception("Token was not obtain", 1);
		}
	
		$client = new Client(['headers'=>[
					'cwauth-token'=>$token,
					'Accept'=>'application/json; charset=utf-8',
					'Content-Type'=>'application/json; charset=utf-8',

			]
		]);
		$res = $client->request('PUT','https://api.voluum.com/lander/'.$lander_id, [
    		'json' => [
        		'url'=>$url,
        		'namePostfix'=>$name
    		]
		]);
		$data = json_decode($res->getBody(), true);
		return $data;
	}

	public static function getReport($campaing_id){
		$token = self::obtainAuthToken();
		if(is_null($token)){
			throw new Exception("Token was not obtain", 1);
		}
		$client = new Client(['headers'=>[
					'cwauth-token'=>$token,
					'Accept'=>'application/json; charset=utf-8',
					'Content-Type'=>'application/json; charset=utf-8',

			]
		]);

		$res = $client->request('GET','https://api.voluum.com/report', [
    		'json' => [
        		'url'=>$url,
        		'namePostfix'=>$name
    		]
		]);

	}

	public static function query($params, $decodeJson = true){
		$token = self::obtainAuthToken();
		if(is_null($token)){
			throw new Exception("Token was not obtain", 1);
		}
		$url = 'https://api.voluum.com/report?'.http_build_query($params);
		//dd($url);
		$client = new Client();
		$res = $client->request('GET','https://api.voluum.com/report', [
			'headers' => ['cwauth-token' => $token ],
			'query'=>$params
		]);
		if ($decodeJson) {
			return json_decode($res->getBody(), true);
		} else {
			return $res->getBody();
		}
		
	}
	public static function campaignReport($campaignId, $dateRange = 'last-30-days', $groupBy = 'custom-variable-1',$offset=0, $limit=15){
		$params = [
			'offset' => $offset,
			'limit' => $limit,
			'filter1' => 'campaign',
			'filter1Value' => $campaignId,
			'sort' => 'day',
			'direction' => 'asc',
			'columns' => [
			'day',
			 'visits',
			 'clicks',
			 'conversions',
			 'revenue',
			 'cost',
			 'profit',
			 'cpv',
			 'ctr',
			 'cr',
			 'cv',
			 'roi',
			 'epv',
			 'epc',
			 'ap',
			 'customVariable1'
			],
			'truncated'=>true,
			'groupBy' => $groupBy,
		
		];
		// Add To / From and TZ to params
		$params = array_merge(self::dateRangeFromSlug($dateRange), $params);
		//dd($params);
		$result = self::query($params);
		return $result;
	}
	
	/**
	* @return an array with 'campaginId' => 'campaignName'
	*/
	public static function getActiveCampaigns(){
		
		$params = [
			'columns' => 'campaignName',
			'groupBy' => 'campaign',
			'offset' => '0',
			'limit' => '1000'
		];
		$params = array_merge(self::dateRangeFromSlug('today'), $params);
		$result =self::query($params);
		// print_r($result['rows']);
		return array_column($result['rows'], 'campaignName','campaignId');
	}

	private static function dateRangeFromSlug($slug){
		date_default_timezone_set(self::TIMEZONE);
		//today = now()@00:00:00
		$from = (new \DateTime)->setTime(0,0);
		$to   = (new \DateTime);
		
		switch ($slug) {
			case 'today':
				$to->add(new \DateInterval('P1D'));
				break;
			case 'yesterday':
				$from->sub(new \DateInterval('P1D'));
				break;
			
			//Last 30 days
			case 'last-30-days':
				$from->sub(new \DateInterval('P29D'));
				$to->add(new \DateInterval('PT2H'));
				break;
			
			//Last 30 days full
			case 'last-full-30-days':
				$from->sub(new \DateInterval('P30D'));
				break;
			//Last 100 days full				
			case 'last-full-100-days':
				$from->sub(new \DateInterval('P100D'));
				break;
		}
		
		// Convert Dates to Voluum Date/Time Format and
		// return array to be used as part of query paramters		
		$dateRange = array(
			'from'	=> $from->format(self::VOLUUM_TIME_FORMAT),
			'to'	=> $to->format(self::VOLUUM_TIME_FORMAT),
			'tz'	=> self::TIMEZONE,
		);
		return $dateRange;
	}
}
