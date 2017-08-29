@extends('layouts.app')
@section('breadcrumb')
 
@endsection
@section('contains')
<div class="row">
         
                <div class="col-lg-12">
                    <div class="clearfix">
                        <h1 class="float-left display-3 mr-2">404</h1>
                        <h4 class="pt-1">Oops! You're lost.</h4>
                        <p class="text-muted">The page you are looking for was not found.</p>
                    </div>
                </div>
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