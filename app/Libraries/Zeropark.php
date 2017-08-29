<?php

namespace App\Libraries;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use Carbon\Carbon;
class Zeropark
{
		public $client;
		public $response;
		public function __construct(){
			$this->client = new Client(['base_uri'=>env('ZEROPARK_API_URL'),'headers'=>[
					'api-token'=>env('ZEROPARK_ACCESS_TOKEN'),
				]
			]);
		}

		public function pauseSource($zeropark_campaign_id, $hash){
			try{
				$this->response = $this->client->request('POST',"/api/campaign/$zeropark_campaign_id/source/pause",
				['form_params'=>[
						'campaignId'=>$zeropark_campaign_id,
						'hash'=>$hash
					]
				]);
				$data = json_decode($this->response->getBody(), true);
				return $data;
			}catch(RequestException $ex){
				return  $ex->getMessage();
			}
			
		}
		public function pauseTarget($zeropark_campaign_id, $hash){
			try{
				$this->response = $this->client->request('POST',"/api/campaign/$zeropark_campaign_id/target/pause",
					['form_params'=>[
							'campaignId'=>$zeropark_campaign_id,
							'hash'=>$hash
						]
					]);
				$data = json_decode($this->response->getBody(), true);
				return $data;
			}catch(RequestException $ex){
				return $ex->getMessage();
				//	$data =[];
				// preg_match_all('/"error":*?/', $ex->getMessage(), $data);
				//  return $data;
			}
		}
		public function resumeTarget($zeropark_campaign_id, $hash){
			try{
				$this->response = $this->client->request('POST',"/api/campaign/$zeropark_campaign_id/target/resume",
					['form_params'=>[
							'campaignId'=>$zeropark_campaign_id,
							'hash'=>$hash
						]
					]);
				$data = json_decode($this->response->getBody(), true);
				return $data;
			}catch(RequestException $ex){
				return $ex->getMessage();
				//	$data =[];
				// preg_match_all('/"error":*?/', $ex->getMessage(), $data);
				//  return $data;
			}
		}
}