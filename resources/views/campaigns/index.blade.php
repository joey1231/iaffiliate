@extends('layouts.app')
@section('breadcrumb')
 <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Campaigns</li>
            </ol>

@endsection
@section('contains')
<div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-align-justify"></i>  List of Campaigns
                                   
                                </div>
                                 <div class="card-block">
                                    <table class="table table-striped table-bordered datatable" id="datatable">
                                        <thead>
                                            <tr>
                                                
                                                <th>Name</th>
                                                <th>Voluum Campaign Id</th>
                                                <th>Ad Network Campaign Id</th>
                                               
                                                <th>Status</th>
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
            if (confirm("Do you want to start/pause this campaign?")) {
                var CSRF_TOKEN =window.Laravel.csrfToken;
                var id = this.id;
                $.ajax({
                    url: "{{url('/campaign/toggle')}}/" + this.id,
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

         $(document).on('click', 'button.delete', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            //$('.delete').click(function () {
            //alert("I am an alert box!");
            if (confirm("Do you want to delete this list?")) {
                var CSRF_TOKEN =window.Laravel.csrfToken;
                var id = this.id;
                $.ajax({
                    url: "{{url('/campaign')}}/" + this.id,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {_token: CSRF_TOKEN},
                    success: function (data, status, header) {
                        row.remove();
                        tr.remove();
                    },
                    error: function (data, status, header) {
                       
                    }
                })
            }
        })

         $(document).on('click', 'button.copy', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            console.log(row.data().report);
            var $temp = $("<textarea>");
              $("body").append($temp);
              $temp.val(row.data().report).select();
              document.execCommand("copy");
              $temp.remove();
        });
           $(document).on('click', 'button.grey', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            console.log(row.data().greylist);
            var $temp = $("<textarea>");
              $("body").append($temp);
              $temp.val(row.data().greylist).select();
              document.execCommand("copy");
              $temp.remove();
        });
             $(document).on('click', 'button.white', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            console.log(row.data().whitelist);
            var $temp = $("<textarea>");
              $("body").append($temp);
              $temp.val(row.data().whitelist).select();
              document.execCommand("copy");
              $temp.remove();
        });
       
         $(document).ready(function () {
        
         table= $('.datatable').DataTable({
            "sDom": "<'row mb-1'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6 center'p>>",
             processing: true,
              serverSide: true,
            renderer: 'bootstrap',
             ajax: '{{url("/campaign/datatable")}}',
             columns: [
                  
                    {data: 'name', name: 'name', orderable: true, searchable: true},
                    {data: 'campaign_id', name: 'campaign_id', orderable: true, searchable: true},
                    {data: 'zeropark_campaign_id', name: 'zeropark_campaign_id', orderable: true, searchable: true},
                    {data: 'status', name: 'status', orderable: true, searchable: true},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
            columnDefs: [
                {
                    render: function (data, type, full, meta) {
                        if(data=="Pause")
                          return "<label style='color:red'>" + data + "</label>";
                        else
                          return "<label style='color:green'>" + data + "</label>";
                    },
                    targets: 3
                },
               
             ],
            order: [0, 'desc'],
            // "oLanguage": {
            //   "sLengthMenu": "_MENU_ records per page"
            // }
          });
        });
    
    
    </script>
     <!-- Vue scripts required by this view -->
   <script src="/js/vue/reports.js"></script>
  
   
@endsection