<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Request\CampaignRequest;
use App\Libraries\Voluum;
use App\Libraries\Zeropark;
use App\Report;
use App\Campaign;
use Datatables;
use App\LogLander;
class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return view('campaigns.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('campaigns.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CampaignRequest $request)
    {
        $campaign = new Campaign();
        $campaign->name = $request->name;
        $campaign->campaign_id = $request->campaign_id;
        $campaign->zeropark_campaign_id= is_null($request->zeropark_campaign_id) ? '':$request->zeropark_campaign_id ;
        $campaign->save();
        return response()->json(['data'=>$campaign,'message'=>'Campaign Created'],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $campaign = Campaign::find($id);
        if(is_null($campaign)){
              return view('errors.404');
        }
        return response()->json(['data'=>$campaign,'message'=>'Campaign Created'],201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $campaign = Campaign::find($id);
        if(is_null($campaign)){
              return view('errors.404');
        }
        return view("campaigns.update", compact('id', 'campaign'));
       
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
       $campaign = Campaign::find($id);
          if(is_null($campaign)){
              return response()->json(['error'=>true,'message' => 'Campaign not found'], 403);
        }
        $campaign->name = $request->name;
        $campaign->campaign_id = $request->campaign_id;
        $campaign->zeropark_campaign_id= is_null($request->zeropark_campaign_id) ? '':$request->zeropark_campaign_id ;
        $campaign->save();

        return response()->json(['data'=>$campaign,'message'=>'Campaign Updated'],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $campaign = Campaign::find($id);
        if(is_null($campaign)){
              return response()->json(['error'=>true,'message' => 'Lander not found'], 403);
        }
        $reports = new Report;
        try{
             $reports->where('cam_id',$id)->delete();
        }catch(\Exception $ex){
            
        }
       
        $campaign->delete();
        return response()->json(['message'=>'Lander Deleted and all urls!'],201);
    }

    public function report($id){
          $campaign = Campaign::find($id);
        if(is_null($campaign)){
              return view('errors.404');
        }
        return view("campaigns.report", compact('id', 'campaign'));
    }
    public function toggleStart($id){
         $campaign = Campaign::find($id);
          if(is_null($campaign)){
              return response()->json(['error'=>true,'message' => 'Campaign not found'], 403);
        }
        $campaign->status =  $campaign->status == 1 ? 0 : 1; 
        $campaign->save();
        if( $campaign->status == 1){
            return response()->json(['data'=>$campaign,'message'=>'Campaign Started'],201);
        }else{
            return response()->json(['data'=>$campaign,'message'=>'Campaign Paused'],201);
        }

    }
    public function Datatable(){
        $reports = new Campaign;
         $datatables = Datatables::of($reports->get());
          $datatables= $datatables->addColumn('status', function ($user) {
                if($user->status == 0){
                    return 'Pause';
                }
                if($user->status==1){
                    return 'Start';
                }
            });

        $datatables= $datatables->addColumn('report', function ($user) {
              $reports = new Report;
             $logs = new LogLander;
             $log = $logs->where('type_start',2)->orderBy('id','DESC')->first();
             if(is_null($log)){
                return ' ';
             }
             $reports_data =$reports->where('cam_id',$user->id)->where('status',Report::BLACK_LIST)->get();
             $text = '';
             foreach ($reports_data as $key => $value) {
                    $text.= $value->customVariable1."\n";
             }
             return $text != '' ? $text : ' ' ;
        });
         $datatables= $datatables->addColumn('whitelist', function ($user) {
              $reports = new Report;
             $logs = new LogLander;
             $log = $logs->where('type_start',2)->orderBy('id','DESC')->first();
             if(is_null($log)){
                return ' ';
             }
             $reports_data =$reports->where('cam_id',$user->id)->where('status',Report::WHITE_LIST)->get();
             $text = '';
             foreach ($reports_data as $key => $value) {
                    $text.= $value->customVariable1."\n";
             }
            return $text != '' ? $text : ' ' ;
        });
          $datatables= $datatables->addColumn('greylist', function ($user) {
              $reports = new Report;
             $logs = new LogLander;
             $log = $logs->where('type_start',2)->orderBy('id','DESC')->first();
             if(is_null($log)){
                return ' ';
             }
             $reports_data =$reports->where('cam_id',$user->id)->where('status',Report::GREY_LIST)->get();
             $text = '';
             foreach ($reports_data as $key => $value) {
                    $text.= $value->customVariable1."\n";
             }
             return $text != '' ? $text : ' ' ;
        });
        $datatables= $datatables->addColumn('action', function ($user) {
            $button='';
             if($user->status == 0){
                     $button= '         
                                             <button id="' . $user->id . '" class="btn btn-xs btn-success ban" title="Start run Algo"><i class="fa fa-play"></i></button>
                                             ';
                }
                if($user->status==1){
                     $button= '         
                                             <button id="' . $user->id . '" class="btn btn-xs btn-danger ban" title="Start Pause"><i class="fa fa-pause"></i></button>
                                             ';
                }
             
        
                $button.='  <button id="' . $user->id . '" class="btn btn-xs btn-danger delete" @click="destroy"><i class="fa fa-trash"></i></button>  <a id="' . $user->id . '" href="'.url('campaign').'/'.$user->id.'/edit'.'"class="btn btn-xs  buttons-edit btn-info" data-button-type="edit"><i class="fa fa-edit"></i></a> <a id="' . $user->id . '" href="'.url('campaign').'/'.$user->id.'/report'.'"class="btn btn-xs  buttons-edit btn-info" data-button-type="edit"><i class="fa fa-binoculars"></i></a> <button id="' . $user->id . '" class="btn btn-xs btn-secondary copy" title="Copy Source ID blacklist" style="background:#000;color:#fff"><i class="fa fa-files-o"></i></button> <button id="' . $user->id . '" class="btn btn-xs btn-secondary white" title="Copy Source ID white" ><i class="fa fa-files-o"></i></button>
                <button id="' . $user->id . '" class="btn btn-xs btn-secondary grey" title="Copy Source ID grey" style="background:grey;"><i class="fa fa-files-o"></i></button>' ;                  
                return $button;
            });
         
         return $datatables->make(true);
    }

     public function reportDatatable($id){
        $reports = new Report;
         $datatables = Datatables::of($reports->where('cam_id',$id)->get());
       
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
                 $data = json_decode($user->ban_response,true);
                 if(is_array($data)){
                     $label = $data['state']['state'];
                 }else{
                    $label = 'Excluded';
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

}
