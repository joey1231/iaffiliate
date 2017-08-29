@extends('layouts.app')
@section('breadcrumb')
 <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Create Campaign</li>
            </ol>

@endsection
@section('contains')
<div class="row">
                        <div class="col-lg-12">
                         <div class="card-header">
                                    <i class="fa fa-align-justify"></i>Create Campaign
                                   
                                </div>
                            <div class="card">
                                 @include('campaigns.fields')

                               @include('global.buttons-new',['button_name'=>'Save'])
                            </div>
                        </div>
                        <!--/.col-->
                    </div>


 @endsection
@section('script-assets')
  <!-- Plugins and scripts required by this views -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.5/handlebars.min.js"></script>
    <script src="/assets/js/libs/jquery.dataTables.min.js"></script>
    <script src="/assets/js/libs/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/js/libs/toastr.min.js"></script>
    <script src="/assets/datatables-editor/js/dataTables.editor.min.js"></script>

      <!-- Vue scripts required by this view -->
   <script src="/js/vue/campaigns.js"></script>
  
 
@endsection