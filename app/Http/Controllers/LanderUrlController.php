<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\GlobalController;
use App\LanderUrl;
use App\Http\Request\AddLanderUrl;
use Illuminate\Http\Response;

class LanderUrlController extends GlobalController
{

     public function __construct(){

      $this->model = new LanderUrl;
      $this->url = url('/lander/urls');
      $this->hasDetails = true;
      $this->datatablecolumns = [
              [
                'label' => "Status",
                'type' => 'override',
                'entity' => 'status', // the method that defines the relationship in your Model
                'attribute' => 'status', // foreign key attribute that is shown to user
                'name'=>'status'
        ]
        ];
        $this->rules = array(

            //'lander_url' =>'required',
           
        );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store($lander_id,AddLanderUrl $request)
    {
        $response='';
        $landerUrl = new LanderUrl;
        $landerUrl->lander_id= $lander_id;
        $landerUrl->lander_url = $request->url;
        $landerUrl->status = $request->status;
        try{
            if($landerUrl->status){
                 $response = $landerUrl->updateUrlVoluumLander();
                 $lander_update = LanderUrl::where('lander_id',$lander_id)->where('status',1)->first();
                 if(!is_null($lander_update)){
                        $lander_update->status= 0;
                        $lander_update->save();
                 }
            }
          
        }catch(\Exception $ex){
             return response()->json(['error'=>true,'message' => $ex->getMessage()], 403);
        }
        $landerUrl->save();
        return response()->json(['data'=>$landerUrl,'voluum_response'=>$response,'message'=>'lander url save'],201);
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
         $landerUrl =LanderUrl::find($id);
          if(is_null($landerUrl)){
              return response()->json(['error'=>true,'message' => 'Lander url not found'], 403);
        }
        $landerUrl->delete();
        return response()->json(['message'=>'Lander url Deleted'],201);
    }

    public function setActive($id){
         $landerUrl =LanderUrl::find($id);
        if(is_null($landerUrl)){
              return response()->json(['error'=>true,'message' => 'Lander url not found'], 403);
        }

         try{
            if($landerUrl->status==0){
                 $response = $landerUrl->updateUrlVoluumLander();
                 $lander_update = LanderUrl::where('lander_id',$landerUrl->lander_id)->where('status',1)->first();
                 if(!is_null($lander_update)){
                        $lander_update->status= 0;
                        $lander_update->save();
                 }
            }
            $landerUrl->status = 1;
            $landerUrl->save();    
        }catch(\Exception $ex){
             return response()->json(['error'=>true,'message' => $ex->getMessage()], 403);
        }
        return response()->json(['error'=>false,'message' => 'Success set as active'], 200);
    }
}
