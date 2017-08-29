@extends('layouts.app')
@section('breadcrumb')
 <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">users</li>
            </ol>

@endsection
@section('contains')
<div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-align-justify"></i>  List of users
                                   
                                </div>
                                 <div class="card-block">
                                    <table class="table table-striped table-bordered datatable" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                              
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
            if (confirm("Do you want to start/pause this user?")) {
                var CSRF_TOKEN =window.Laravel.csrfToken;
                var id = this.id;
                $.ajax({
                    url: "{{url('/user/toggle')}}/" + this.id,
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
             ajax: '{{url("/user/datatable")}}',
             columns: [
                    {data: 'id', name: 'id', orderable: true, searchable: true},
                    {data: 'name', name: 'name', orderable: true, searchable: true},
                    {data: 'email', name: 'email', orderable: true, searchable: true},
                  
                    {data: 'action', name: 'action', orderable: false, searchable: false}
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