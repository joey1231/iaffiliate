<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Http\Controllers\GlobalController;
use App\Lander;
use App\LanderUrl;
use App\Http\Request\AddLander;

class LanderController extends GlobalController
{

     public function __construct(){

      $this->model = new Lander;
      $this->url = url('/lander/list');
      $this->hasDetails = true;
      $this->datatablecolumns = [
          [
                'label' => "urls",
                'type' => 'counter',
                'entity' => 'urls', // the method that defines the relationship in your Model
                'attribute' => 'lander_url', // foreign key attribute that is shown to user
                'name'=>'urls'
          ]
        ];
     $this->datatablecolumnsdetails = [
        [
                'label' => "Status",
                'type' => 'override',
                'entity' => 'status', // the method that defines the relationship in your Model
                'attribute' => 'status', // foreign key attribute that is shown to user
                'name'=>'status'
        ]
     ];
      $this->rules = array(

            'lander_id' =>'required',
            'lander_name' =>'required',
        );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('lander.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lander.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddLander $request)
    {
      $lander = new Lander;
      $lander->lander_name = $request->lander_name;
      $lander->lander_id = $request->lander_id;
      $lander->save();
      return response()->json(['message' => 'Succesfully Create Lander!'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lander = Lander::find($id);
        if(is_null($lander)){
              return response()->json(['error'=>true,'message' => 'Lander not found'], 403);
        }
        return response()->json(['data'=>$lander,'message'=>'Lander found'],201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $lander = Lander::find($id);
        if(is_null($lander)){
              return response()->json(['error'=>true,'message' => 'Lander not found'], 403);
        }
        return view("lander.update", compact('id', 'lander'));
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
         $lander = Lander::find($id);
        if(is_null($lander)){
              return response()->json(['error'=>true,'message' => 'Lander not found'], 403);
        }
        
        $lander->lander_name = $request->lander_name;
        $lander->lander_id = $request->lander_id;
        $lander->save();
        return response()->json(['data'=>$lander,'message'=>'Lander Updated!'],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $lander = Lander::find($id);
        if(is_null($lander)){
              return response()->json(['error'=>true,'message' => 'Lander not found'], 403);
        }

        $lander->urls()->delete();
        $lander->delete();
        return response()->json(['message'=>'Lander Deleted and all urls!'],201);
    }

    public function addBulk($id){
        $lander = Lander::find($id);
        if(is_null($lander)){
              return view('errors.404');
        }

        return view('lander.bulk_urls',compact('lander'));
    }

    public function saveBulk(Request $request, $id){
          $lander = Lander::find($id);
        if(is_null($lander)){
              return response()->json(['error'=>true,'message' => 'Lander not found'], 403);
        }
        foreach ($request->urls as $key => $value) {
                $landerUrl = new LanderUrl;
                $landerUrl->lander_id= $lander->id;
                $landerUrl->lander_url = $value;
                $landerUrl->save();
        }
         return response()->json(['message'=>'Lander bulk urls created'],201);
    }
}
