<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\GlobalController;
use App\User;
use Datatables;
use App\Http\Request\AddUser;
class UserController extends Controller
{
    
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddUser $request)
    {
      $users = new User;
      $users->name = $request->name;
      $users->email = $request->email;
      $users->password = bcrypt($request->password);
      $users->save();
      return response()->json(['message' => 'Succesfully Create users!'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = User::find($id);
        if(is_null($users)){
              return response()->json(['error'=>true,'message' => 'users not found'], 403);
        }
        return response()->json(['data'=>$users,'message'=>'users found'],201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $user = User::find($id);
        if(is_null($user)){
              return view('errors.404');
        }
        return view("users.update", compact('id', 'user'));
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
         $users = User::find($id);
        if(is_null($users)){
              return response()->json(['error'=>true,'message' => 'users not found'], 403);
        }
        
        $users->name = $request->name;
        $users->email = $request->email;
        $users->password = bcrypt($request->password);
        $users->save();
        return response()->json(['data'=>$users,'message'=>'users Updated!'],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $users = User::find($id);
        if(is_null($users)){
              return response()->json(['error'=>true,'message' => 'users not found'], 403);
        }

        
        $users->delete();
        return response()->json(['message'=>'users Deleted and all urls!'],201);
    }
   
    public function toggleStart($id){
         $user = User::find($id);
          if(is_null($user)){
              return response()->json(['error'=>true,'message' => 'user not found'], 403);
        }
        $user->status =  $user->status == 1 ? 0 : 1; 
        $user->save();
        if( $user->status == 1){
            return response()->json(['data'=>$user,'message'=>'user Started'],201);
        }else{
            return response()->json(['data'=>$user,'message'=>'user Paused'],201);
        }

    }
     public function Datatable(){
        $reports = new User;
         $datatables = Datatables::of($reports->where('id','!=',2)->get());
          
        $datatables= $datatables->addColumn('action', function ($user) {
            $button='';
          
                $button.=' <a id="' . $user->id . '" href="'.url('user').'/'.$user->id.'/edit'.'"class="btn btn-xs  buttons-edit btn-info" data-button-type="edit"><i class="fa fa-edit"></i></a>' ; 
                            
                return $button;
            });
         
         return $datatables->make(true);
    }
}
