<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Request\CampaignRequest;
use App\Libraries\Voluum;
use App\Libraries\Zeropark;
use App\Report;
use Datatables;
use App\Campaign;
use App\LogLander;
class ReportController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return view('reports.index');
        return view('reports.run_algo');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CampaignRequest $request)
    {
        $reports = [];
        try{
             $response = Voluum::campaignReport($request->campaign_id);
             
        }catch(\Exception $ex){
              return response()->json(['error'=>true,'message' => 'Exception found'], 403);
        }
        if(isset($response['rows'])){
             $campaign = Campaign::where('campaign_id', $request->campaign_id)->where('zeropark_campaign_id',$request->zeropark_campaign_id)->first();
             if(is_null($campaign)){
                $campaign = new Campaign;
                $campaign->name = $request->campaign_id;
                $campaign->campaign_id = $request->campaign_id;
                $campaign->zeropark_campaign_id= $request->zeropark_campaign_id;
                $campaign->save();
             }
           
                    foreach ($response['rows'] as $key => $value) {
                        $status = Report::runAlgo($value['cost'],$value['roi']);
                        // check if status is not null
                        if(!is_null($status)){
                             $report = Report::where('campaign_id',$request->campaign_id)->where('zeropark_campaign_id',$request->zeropark_campaign_id)->where('customVariable1',$value['customVariable1'])->first();
                             if(is_null($report)){
                                 $report = new Report;
                                 $report->fill($value);
                                 $report->status=$status;
                                 $report->campaign_id = $request->campaign_id;
                                 $report->cam_id = $campaign->id;
                                 $report->zeropark_campaign_id= $request->zeropark_campaign_id;
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
             }
         return response()->json(['data'=>$reports,'message'=>'Successfully Run Algo'],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function Datatable(){
        $reports = new Report;
         $datatables = Datatables::of($reports->get());
       
         $datatables= $datatables->addColumn('label', function ($user) {

               $label ='';
                  if($user->status == Report::BLACK_LIST){
                    $label='BlackList';
                  }
                  if($user->status==Report::GREY_LIST){
                     $label='GreyList';
                  }
                  if($user->status==Report::WHITE_LIST){
                     $label='WhiteList';
                  }
          return $label;
        });
         $datatables= $datatables->addColumn('ban_status', function ($user) {

               $label ='';
                  if($user->ban_status ==0){
                    $label='Not Ban';
                  }
                  if($user->ban_status==1){
                     $label='Banned';
                  }
                 
          return $label;
        });
          $datatables= $datatables->addColumn('ban_response', function ($user) {

               $label =" ".$user->ban_response." ";
                 
                 
          return $label;
        });
         
        $datatables= $datatables->addColumn('action', function ($user) {
                $button='';
             if($user->status == Report::BLACK_LIST && $user->ban_status ==0){
                     $button= '         
                                             <button id="' . $user->id . '" class="btn btn-xs btn-danger ban" title="Ban this source to zeropark"><i class="fa fa-ban"></i></button>
                                             ';
            }
            if($user->status == Report::BLACK_LIST && $user->ban_status ==1){
                     $button= '         
                                             <button id="' . $user->id . '" class="btn btn-xs btn-success resume" title="Resume this source to zeropark"><i class="fa fa-check-circle-o"></i></button>
                                             ';
            }
            if($user->status==Report::GREY_LIST){
                    
            }
             if($user->status==Report::WHITE_LIST){
                   
             }
        
                                  
                return $button;
            });
         
         return $datatables->make(true);
    }
    public function report(){
       
        return view('reports.run_algo');
    }

    public function manualPause($id){
        $report = Report::find($id);
        if(is_null($report)){
            return response()->json(['error'=>true,'message' => 'Report Not found'], 403);
        }
        $response = $this->pauseTarget($report->zeropark_campaign_id,$report->customVariable1);
        if(is_array($response)){
            $report->ban_status = 1;
            $report->ban_response = json_encode($response);

        }else{
              $report->ban_response = $response;
        }
        $report->save();
        return response()->json(['data'=>$response,'message'=>'Successfully Banned'],201);
    }
    public function manualResume($id){
         $report = Report::find($id);
        if(is_null($report)){
            return response()->json(['error'=>true,'message' => 'Report Not found'], 403);
        }
        $response = $this->resumeTarget($report->zeropark_campaign_id,$report->customVariable1);
        if(is_array($response)){
            $report->ban_status = 0;
            $report->ban_response = json_encode($response);

        }else{
              $report->ban_response = $response;
        }
        $report->save();
        return response()->json(['data'=>$response,'message'=>'Successfully Banned'],201);
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

     public function DatatableLog($type){
        $reports = new LogLander;
         $datatables = Datatables::of($reports->where('type_start',$type)->get());
          $datatables= $datatables->addColumn('type', function ($user) {
                if($user->type_start ==1){
                    return 'Lander';
                }
                if($user->type_start ==2){
                    return 'Campaign';
                }
                
            });
       
         return $datatables->make(true);
    }
    public function log($name,$type){
        return view('logs.index',compact('name','type'));
    }
}
