@extends('layouts.app')
@section('vue-props')
  :id="id='{{$lander->id}}'"
 
@endsection
@section('breadcrumb')
 <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Create List</li>
            </ol>

@endsection
@section('contains')
<div class="row">
                        <div class="col-lg-12">
                         <div class="card-header">
                                    <i class="fa fa-align-justify"></i> Create Bulk urls - @{{lander.lander_name}}
                                   
                                </div>
                            <div class="card">
                               <div class="card-block">
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">URL</span>
                                                <textarea id="username3" name="username3" class="form-control" type="text" v-model="url" :disabled="submitting" ></textarea> 
                                                
                                            </div>
                                        </div>
                                       
                                        
                                        <hr/>
                                       
                                        
                                       <div class="sk-wave" v-show="submitting">
                                        <div class="sk-rect sk-rect1"></div>
                                        <div class="sk-rect sk-rect2"></div>
                                        <div class="sk-rect sk-rect3"></div>
                                        <div class="sk-rect sk-rect4"></div>
                                        <div class="sk-rect sk-rect5"></div>
                                    </div>
                                    </form>
                                </div>

                             <div class="card-block">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" @click="addLanderPost" :disabled="submitting" >Create</button>
</div>
                            </div>
                        </div>
                        <!--/.col-->
                    </div>
   
                <!-- /.modal -->                
                    <!--/.row-->
@endsection
@section('script-assets')
  <!-- Plugins and scripts required by this views -->
    <script src="/assets/js/libs/jquery.dataTables.min.js"></script>
    <script src="/assets/js/libs/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/js/libs/toastr.min.js"></script>
    
     <!-- Vue scripts required by this view -->
   <script src="/js/vue/lander.js"></script>

@endsection