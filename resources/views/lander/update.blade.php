@extends('layouts.app')
@section('vue-props')
  :id="id='{{$lander->id}}'"
 
@endsection
@section('breadcrumb')
 <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">lander landering</li>
            </ol>

@endsection
@section('contains')
<div class="row">
                        <div class="col-lg-12">
                         <div class="card-header">
                                    <i class="fa fa-align-justify"></i>lander Create
                                   
                                </div>
                            <div class="card">
                                 @include('lander.fields')

                               @include('global.buttons-update')
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