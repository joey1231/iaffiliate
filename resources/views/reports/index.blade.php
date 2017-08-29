@extends('layouts.app')
@section('breadcrumb')
 <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Reports</li>
            </ol>

@endsection
@section('contains')
<div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-align-justify"></i>  List of Reports
                                   
                                </div>
                                 <div class="card-block">
                                    <table class="table table-striped table-bordered datatable" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Source ID</th>
                                                <th>ROI</th>
                                                <th>Cost</th>
                                                <th>Campaign Id</th>
                                                <th>Zeropark Campaign Id</th>
                                                <th>Label</th>
                                                <th>Ban Status</th>
                                                <th width="300px">Ban Response</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                       
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
    <script type="text/javascript">
        var table;
        var template;
        var table_template={};
        var editor;
        var details_editor=[];
        $(document).on('click', 'button.ban', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            //$('.delete').click(function () {
            //alert("I am an alert box!");
            if (confirm("Do you want to Ban this source?")) {
                var CSRF_TOKEN =window.Laravel.csrfToken;
                var id = this.id;
                $.ajax({
                    url: "{{url('/report/pause')}}/" + this.id,
                    type: 'POST',
                    dataType: 'json',
                    data: {_token: CSRF_TOKEN},
                    success: function (data, status, header) {
                        //row.remove();
                        //tr.remove();
                      console.log(data);
                       table.ajax.reload();
                    },
                    error: function (data, status, header) {
                        console.log(data);
                    }
                })
            }
        });
         $(document).on('click', 'button.resume', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            //$('.delete').click(function () {
            //alert("I am an alert box!");
            if (confirm("Do you want to resume this source?")) {
                var CSRF_TOKEN =window.Laravel.csrfToken;
                var id = this.id;
                $.ajax({
                    url: "{{url('/report/resume')}}/" + this.id,
                    type: 'POST',
                    dataType: 'json',
                    data: {_token: CSRF_TOKEN},
                    success: function (data, status, header) {
                        //row.remove();
                        //tr.remove();
                      console.log(data);
                       table.ajax.reload();
                    },
                    error: function (data, status, header) {
                        console.log(data);
                    }
                })
            }
        });
       
         $(document).ready(function () {
      
         table= $('.datatable').DataTable({
            "sDom": "<'row mb-1'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6 center'p>>",
             processing: true,
              serverSide: true,
            renderer: 'bootstrap',
             ajax: '{{url("/report/datatable")}}',
             columns: [
                    {data: 'id', name: 'id', orderable: true, searchable: true},
                    {data: 'customVariable1', name: 'customVariable1', orderable: true, searchable: true},
                    {data: 'roi', name: 'roi', orderable: true, searchable: true},
                    {data: 'cost', name: 'cost', orderable: true, searchable: true},
                    {data: 'campaign_id', name: 'campaign_id', orderable: true, searchable: true},
                    {data: 'zeropark_campaign_id', name: 'zeropark_campaign_id', orderable: true, searchable: true},
                    {data: 'label', name: 'label', orderable: true, searchable: true},
                    {data: 'ban_status', name: 'ban_status', orderable: true, searchable: true},
                    {data: 'ban_response', name: 'ban_response', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
            columnDefs: [
                {
                    render: function (data, type, full, meta) {
                        return "<pre style='background:#fff;border:1px solid #000;max-width:300px'> <code>" + data + "</code></pre>";
                    },
                    targets: 8
                },
                 {
                    render: function (data, type, full, meta) {
                        if(data=='WhiteList')
                         return "<label style='color:#fff;background:green'>" + data + "</label>";
                         if(data=='BlackList')
                         return "<label style='color:#fff;background:#000'>" + data + "</label>";
                      if(data=='GreyList')
                         return "<label style='color:#000;background:grey'>" + data + "</label>";
                    },
                    targets: 6
                }
             ],
            order: [0, 'desc'],
            // "oLanguage": {
            //   "sLengthMenu": "_MENU_ records per page"
            // }
          });
        });
    
    
    </script>
     <!-- Vue scripts required by this view -->
   <script src="/js/vue/campaign.js"></script>
  
   
@endsection