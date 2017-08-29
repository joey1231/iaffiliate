@extends('layouts.app')
@section('breadcrumb')
 <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Lander</li>
            </ol>

@endsection
@section('contains')
<div class="row">
                        <div class="col-lg-12">
                         <div class="card-header">
                                    <i class="fa fa-align-justify"></i>Run Algorithm  
                                   
                                </div>
                            <div class="card">
                                 @include('reports.fields')

                               @include('global.buttons-new',['button_name'=>'Run'])
                            </div>
                        </div>
                        <!--/.col-->
                    </div>

<div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-align-justify"></i>  List of Blacklist , Greylist and Whitelist
                                   
                                </div>
                                 <div class="card-block">
                                    <table class="table table-striped table-bordered datatable" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>Source ID</th>
                                                <th>ROI</th>
                                                <th>Cost</th>
                                                <th>Label</th>
                                                 <th>Ban Status</th>
                                                <th width="300px">Ban Response</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        		<tr v-for="report in reports">
                                        			<td>@{{report.customVariable1}}</td>
                                        			<td>@{{report.roi}}</td>
                                        			<td>@{{report.cost}}</td>
                                        			<td v-text="showStatus(report.status)"></td>
                                                    <td v-text="showBanStatus(report.ban_status)"></td>
                                                    <td v-html="showBanResponse(report.ban_response)"></td>
                                        			<td><button class="btn btn-danger" @click="banStatus(report.id)"><i class="fa fa-unlock-alt"> </i>Block</button></td>
                                        		</tr>
                                        </tbody>
                                       
                                    </table>
                                   
                                        
                                    
                                </div>
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
   <script src="/js/vue/reports.js"></script>
  
 
@endsection