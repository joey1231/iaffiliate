<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Libraries\Voluum;
use App\Libraries\Zeropark;
use App\Report;
use App\Campaign;
use App\LogLander;
class CampaignScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'campaign run algo';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Campaign start Running..');
        $logLander = new LogLander();
        $logLander->type_start = 2;
        $logLander->save();
        $reports = new Campaign;
        $campaigns = $reports->where('status',1)->get();
        foreach ($campaigns as $key => $campaign) {
              try{
                     $response = Voluum::campaignReport($campaign->campaign_id);
                       $reports=array();  
                      foreach ($response['rows'] as $c => $value) {
                        $status = Report::runAlgo($value['cost'],$value['roi']);
                        // check if status is not null
                        if(!is_null($status)){
                             $report = Report::where('campaign_id',$campaign->campaign_id)->where('zeropark_campaign_id',$campaign->zeropark_campaign_id)->where('customVariable1',$value['customVariable1'])->first();
                             if(is_null($report)){
                                 $report = new Report;
                                 $report->fill($value);
                                 $report->status=$status;
                                 $report->campaign_id = $campaign->campaign_id;
                                 $report->cam_id = $campaign->id;
                                 $report->zeropark_campaign_id= $campaign->zeropark_campaign_id;
                                 $report->save();  
                             }else{
                                $report->status=$status;
                                $report->fill($value);
                                $report->save();  
                             }
                             if($status==Report::BLACK_LIST){
                                  $response = $this->pauseTarget($report->zeropark_campaign_id,$report->customVariable1);
                                   if(is_array($response)){
                                        $report->ban_status = 1;
                                        $report->ban_response = json_encode($response);

                                    }else{
                                          $report->ban_response = $response;
                                    }
                                    $report->save();
                             }
                             if($status==Report::WHITE_LIST){
                                  $response = $this->resumeTarget($report->zeropark_campaign_id,$report->customVariable1);
                                   if(is_array($response)){
                                        $report->ban_status = 0;
                                        $report->ban_response = json_encode($response);

                                    }else{
                                          $report->ban_response = $response;
                                    }
                                    $report->save();
                             }
                             
                             
                              $reports[]=$report;
                        }
                    
                    }
                    usleep(80);
            }catch(\Exception $ex){
                     $this->info($ex->getMessage());
                     continue;
            }

            
        }
        $logLander->type_end = 2;
        $logLander->save();
        $this->info('Campaign stop Running..');
    }

     private function pauseSource($zeropark_campaign_id, $hash){
        $zerpark = new Zeropark();
        $response = $zerpark->pauseSource($zeropark_campaign_id,$hash);
        return $response;
    }
     private function pauseTarget($zeropark_campaign_id, $hash){
        $zerpark = new Zeropark();
        $response = $zerpark->pauseTarget($zeropark_campaign_id,$hash);
        return $response;
    }
    private function resumeTarget($zeropark_campaign_id, $hash){
        $zerpark = new Zeropark();
        $response = $zerpark->resumeTarget($zeropark_campaign_id,$hash);
        return $response;
    }
}
