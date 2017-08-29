<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Datatables;
class GlobalController extends Controller
{
    public $model=null;
    public $datatablecolumns=array();
    public $datatablecolumnsdetails=array();
    public $url;
    public $hasDetails=false;
    public $action =true;
    public $rules=[];
    public function Datatable(){

    	 $datatables = Datatables::of($this->model->get());
        foreach ($this->datatablecolumns as $column) {

        	if ($column['type'] == 'select') {
                $datatables = $datatables->addColumn($column['entity'], function ($user) use ($column) {
                    if (isset($user->{$column['name']})) {
                        if(isset($user->{$column['name']}[$column['attribute']])){
                            return $user->{$column['name']}[$column['attribute']];
                        }else{
                            return '';
                        }

                    } else {
                        return '';
                    }
                });
            }
            if ($column['type'] == 'select_multiple') {
                $datatables = $datatables->addColumn($column['name'], function ($user) use ($column) {
                    $string = '';
                    $flag = false;
                    foreach ($user->{$column['name']} as $key) {
                    	if($flag==false){
                    		 	$string .= $key->{$column['attribute']} . "";
                    		 	$flag=true;
                    		}else{
                    			 $string .=  ",<br/>".$key->{$column['attribute']} ;
                    		}
                       
                    }
                    return $string;
                });
            }
            if ($column['type'] == 'counter') {
                $datatables = $datatables->addColumn($column['name'], function ($user) use ($column) {
                    return $user->{$column['name']}->count();
                });
            }
        }
        if($this->action){
        $datatables= $datatables->addColumn('action', function ($user) {

                $button= '
                                            <a id="' . $user->id . '" href="'.$this->url.'/'.$user->id.'/edit'.'"class="btn btn-xs  buttons-edit btn-info" data-button-type="edit"><i class="fa fa-edit"></i></a>
                                             <button id="' . $user->id . '" class="btn btn-xs btn-danger delete" @click="destroy"><i class="fa fa-trash"></i></button>   <a id="' . $user->id . '" href="'.$this->url.'/bulk/'.$user->id.'"class="btn btn-xs  buttons-edit btn-success" data-button-type="edit"><i class="fa fa-plus" title="Add bulk urls"></i></a>
                                             ';
                if($this->hasDetails){
                    $button.= '<button id="' . $user->id . '" class="btn btn-info view" ><i class="fa fa-binoculars"></i></button>';
                }                                
                return $button;
            });
         }
         return $datatables->make(true);
    }
    public function updateData(Request $request)
    {


        $validate = array();
        $inputs = array();
        $id = 0;
        if ($request->get('action') == 'edit') {


            foreach ($request->get('data') as $key => $value) {


                $id = $key;
                foreach ($value as $k => $v) {
                    if (isset($this->rules)) {
                        if (array_key_exists($k, $this->rules)) {
                            $rule = $this->rules[$k];
                            if (strpos($rule, 'unique') !== false) {
                                $rule .= ',' . $key;
                            }
                            $validate[$k] = $rule;
                        }
                    }
                     $inputs[$k] = $v;
                   


                }

                //
            }


        }

        

        $validator = Validator::make($inputs, $validate);
        //Check if the erros is not empty
        if ($validator->fails()) {
            //get all the errors;
            $error = $validator->errors()->all();
            $msg = '';
            foreach ($error as $i => $v) {
                $msg = $v;
            }

            return response(['error' => $msg], 400);
        }

        $model = $this->model->find($id);
        if (is_null($model)) {
            foreach ($inputs as $key => $input) {
                // log data
                
                $this->model->{$key} = $input;
            }
            $this->model->save();


        } else {
            foreach ($inputs as $key => $input) {
                $model->{$key} = $input;
            }
            $model->save();
        }

        return $this->Datatable();

    }
    public function DatatableAttach($attach){

         $datatables = Datatables::of($this->model->get());
        foreach ($this->datatablecolumns as $column) {

            if ($column['type'] == 'select') {
                $datatables = $datatables->addColumn($column['entity'], function ($user) use ($column) {
                    if (isset($user->{$column['name']})) {
                        if(isset($user->{$column['name']}[$column['attribute']])){
                            return $user->{$column['name']}[$column['attribute']];
                        }else{
                            return '';
                        }

                    } else {
                        return '';
                    }
                });
            }
            if ($column['type'] == 'select_multiple') {
                $datatables = $datatables->addColumn($column['name'], function ($user) use ($column) {
                    $string = '';
                    $flag = false;
                    foreach ($user->{$column['name']} as $key) {
                        if($flag==false){
                                $string .= $key->{$column['attribute']} . "";
                                $flag=true;
                            }else{
                                 $string .=  ",<br/>".$key->{$column['attribute']} ;
                            }
                       
                    }
                    return $string;
                });
            }
            if ($column['type'] == 'counter') {
                $datatables = $datatables->addColumn($column['name'], function ($user) use ($column) {
                    return $user->{$column['name']}->count();
                });
            }
        }

        $datatables= $datatables->addColumn('action', function ($user) use ($attach){

                $button= '
                                             <button id="' . $user->id . '" class="btn btn-xs btn-success attach" data-list="'.$attach.'" @click="destroy"><i class="fa fa-plus"></i></button>
                                             ';
                                             
                return $button;
            });

         return $datatables->make(true);
    }

    public function DatatableDetails($relation,$id){
          
         $datatables = Datatables::of($this->model->where('id',$id)->first()->{$relation}()->get());
      
        foreach ($this->datatablecolumnsdetails as $column) {

            if ($column['type'] == 'select') {
                $datatables = $datatables->addColumn($column['entity'], function ($user) use ($column) {
                    if (isset($user->{$column['name']})) {
                        if(isset($user->{$column['name']}[$column['attribute']])){
                            return $user->{$column['name']}[$column['attribute']];
                        }else{
                            return '';
                        }

                    } else {
                        return '';
                    }
                });
            }
            if ($column['type'] == 'select_multiple') {
                $datatables = $datatables->addColumn($column['name'], function ($user) use ($column) {
                    $string = '';
                    $flag = false;
                    foreach ($user->{$column['name']} as $key) {
                        if($flag==false){
                                $string .= $key->{$column['attribute']} . "";
                                $flag=true;
                            }else{
                                 $string .=  ",<br/>".$key->{$column['attribute']} ;
                            }
                       
                    }
                    return $string;
                });
            }
            if ($column['type'] == 'counter') {
                $datatables = $datatables->addColumn($column['name'], function ($user) use ($column) {
                    return $user->{$column['name']}->count();
                });
            }
             if ($column['type'] == 'override') {
                $datatables = $datatables->addColumn($column['name'], function ($user) use ($column) {
                        $text = '';
                        if($user->{$column['name']} == 1){
                            $text = 'Active';
                        }else{
                            $text = 'Not Active';
                        }
                        return $text;
                });
            }
        }

        $datatables= $datatables->addColumn('action', function ($user) use($id) {

                if($user->status == 1){
                   $button='';
                }else{
                     $button= '
                                            
                                             <button id="' . $user->id . '" class="btn btn-primary active detach" data-list="'.$id.'"><i class="icon-link icons"></i></button>
                                             ';
                }
                $button.='<button id="' . $user->id . '" class="btn btn-xs btn-danger delete-details" ><i class="fa fa-trash"></i></button>';
               

                return $button;
            });

         return $datatables->make(true);
    }

}
