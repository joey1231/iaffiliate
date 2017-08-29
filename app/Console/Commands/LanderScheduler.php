<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Lander;
use App\LogLander;
use App\LanderUrl;
class LanderScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lander:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lander Change url';

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
        $this->info('Lander start Running..');
        $logLander = new LogLander();
        $logLander->type_start = 1;
        $logLander->save();
        $lander = new Lander();
        $landers = $lander->get();
        foreach ($landers as $key => $value) {
            $lander_url_active = $value->urls()->where('status',1)->first();
            if(!is_null($lander_url_active)){
                  $lander_urls = $value->urls()->where('status',0)->where('id','>',$lander_url_active->id)->first();
                  if(is_null($lander_urls)){
                     $lander_urls = $value->urls()->where('status',0)->first();
                  }
              }else{
                  $lander_urls = $value->urls()->where('status',0)->first();
              }
          
            if(is_null($lander_urls)){
                  $this->info($value->lander_name.' No Urls');
                  continue;
            }
            $lander_urls->updateUrlVoluumLander();
            try{
                 if(!is_null($lander_url_active)){
                     $lander_url_active->status=0;
                     $lander_url_active->save();
                 }
               
            }catch(\Exception $ex){

            }
            $lander_urls->status=1;
            $lander_urls->save();
            usleep(80);
           
        }
        $logLander->type_end = 1;
        $logLander->save();
        $this->info('Lander stop Running..');
    }
}
