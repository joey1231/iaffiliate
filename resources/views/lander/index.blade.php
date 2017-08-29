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
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-align-justify"></i>  List of Lander
                                    <div class="card-actions btn-primary">
                                        <a href="#"  data-toggle="modal" data-target="#primaryModal">
                                           <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                 <div class="card-block">
                                    <table class="table table-striped table-bordered datatable" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>Name</th>
                                                <th>Lander Id</th>
                                                <th>Urls</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                       
                                    </table>
                                   
                                        
                                    
                                </div>
                            </div>
                        </div>
                        <!--/.col-->
                    </div>
    <div class="modal fade" id="primaryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-primary" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Create Lander</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                               @include('lander.fields')
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" @click="save" :disabled="submitting" >Save changes</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->                
                    <!--/.row-->

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
        $(document).on('click', 'button.delete', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            //$('.delete').click(function () {
            //alert("I am an alert box!");
            if (confirm("Do you want to delete this list?")) {
                var CSRF_TOKEN =window.Laravel.csrfToken;
                var id = this.id;
                $.ajax({
                    url: "{{url('/lander/list')}}/" + this.id,
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
        $(document).on('click', 'button.delete-details', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            //$('.delete').click(function () {
            //alert("I am an alert box!");
            if (confirm("Do you want to delete this list?")) {
                var CSRF_TOKEN =window.Laravel.csrfToken;
                var id = this.id;
                $.ajax({
                    url: "{{url('/lander-url/')}}/" + this.id,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {_token: CSRF_TOKEN},
                    success: function (data, status, header) {
                        //row.remove();
                        tr.remove();
                    },
                    error: function (data, status, header) {
                       
                    }
                })
            }
        })
        $(document).on('click', 'button.attach', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            //$('.delete').click(function () {
            //alert("I am an alert box!");
            if (confirm("Do you want to attach this list?")) {
                var CSRF_TOKEN =window.Laravel.csrfToken;
                var id = this.id;
                var list = $(this).data().list;
                
                $.ajax({
                    url: "{{url('/lander/attach')}}/" + $(this).data().list+"/"+this.id,
                    type: 'POST',
                    dataType: 'json',
                    data: {_token: CSRF_TOKEN},
                    success: function (data, status, header) {
                         toastr.success('Attach Contact!', data.message, {
                            closeButton: true,
                            progressBar: false,
                          });
                        
                         table_template['detail-' + list].ajax.reload();
                    },
                    error: function (data, status, header) {
                      
                    }
                })
            }
        })
         $(document).on('click', 'button.detach', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            //$('.delete').click(function () {
            //alert("I am an alert box!");
            if (confirm("Do you want to set active this url to voluum?")) {
                var CSRF_TOKEN =window.Laravel.csrfToken;
                var id = this.id;
                var list = $(this).data().list;
                
                $.ajax({
                    url: "{{url('lander-url/set-active/')}}/" + this.id,
                    type: 'GET',
                    dataType: 'json',
                    data: {_token: CSRF_TOKEN},
                    success: function (data, status, header) {
                         toastr.success('Attach Contact!', data.message, {
                            closeButton: true,
                            progressBar: false,
                          });
                    
                         table_template['detail-' + list].ajax.reload();
                    },
                    error: function (data, status, header) {
                     
                    }
                })
            }
        })
         $(document).ready(function () {
        
        editor = new $.fn.dataTable.Editor({
                ajax: '{{url("/lander/editor")}}',
                table: "#datatable",
                fields: [
                        {label: "Name", name: "lander_name", type: 'text', options: []},
                        {label: "Lander id", name: "lander_id", type: 'text', options: []}
                ],
                idSrc: 'id',
            });

        $(document).on('click', '#datatable tr td', function (e) {
            try{
                     var tr = $(this).closest('tr');
                 var row = table.row(tr);
              
             
                var id = "undefined";
                var data = row.data();
                if(typeof data != "undefined"){
                     id = row.data().id;
                }
                
                if (typeof id != "undefined" && tr.parent().parent().attr('id') == "datatable") {
                   
                    if (e.toElement.cellIndex > 0 && e.toElement.cellIndex < 3) {
                       
                     
                        editor.inline(this);
                    }
                    
                }
            }catch( ex){

            }
               
            });
        template = Handlebars.compile($("#contacts-attach-list").html());
      

         table= $('.datatable').DataTable({
            "sDom": "<'row mb-1'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6 center'p>>",
             processing: true,
              serverSide: true,
            renderer: 'bootstrap',
             ajax: '{{url("/lander/datatable")}}',
             columns: [
                    {data: 'id', name: 'id', orderable: true, searchable: true},
                    {data: 'lander_name', name: 'lander_name', orderable: true, searchable: true},
                    {data: 'lander_id', name: 'lander_id', orderable: true, searchable: true},
                    {data: 'urls', name: 'urls', orderable: true, searchable: true},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
            order: [0, 'desc'],
            // "oLanguage": {
            //   "sLengthMenu": "_MENU_ records per page"
            // }
          });
        });
        // Add event listener for opening and closing details
    $(document).on('click', 'button.view', function () {
        console.log('clicked');
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        var tableId = 'detail-' + row.data().id;
        var tableIdcontact = 'detail-urls-' + row.data().id;
        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child([template(row.data())]).show();
            //row.appendChild( template_movies(row.data())).show();
            initTable(tableId, row.data());
          
            tr.addClass('shown');
            tr.next().find('td').addClass('no-padding bg-gray');
        }
    });

    // create person for department
    $(document).on('click', 'button.save-person', function () {
            var id =this.id;
            var progress =$('.hide_'+id);
          
            progress.show();
             var CSRF_TOKEN =window.Laravel.csrfToken;
            var fields = {
                'url':$('.url_'+id).val(),
                'status':$('.status_'+id).is(':checked') ? 1 : 0,
                _token: CSRF_TOKEN
            }
          
                var list =this.id;
                
                $.ajax({
                    url: "{{url('/lander-url/store/')}}/" +this.id,
                    type: 'POST',
                    dataType: 'json',
                    data: fields,
                    success: function (data, status, header) {
                         toastr.success('Lander Url Created', data.message, {
                            closeButton: true,
                            progressBar: false,
                          });
                       
                         table_template['detail-' + list].ajax.reload();
                         $('.url_'+list).val('')
                         progress.hide();
                          $("#secondaryModal-"+list+" .close").click()
                    },
                    error: function (data, status, header) {
                      
                        alert(data.responseText);
                        progress.hide()
                    }
                })
    });
    function initTable(tableId, data) {
     
       table_template[tableId] = $('#' + tableId).DataTable({
            "sDom": "<'row mb-1'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6 center'p>>",
             processing: true,
              serverSide: true,
            renderer: 'bootstrap',
             ajax: '{{url("/lander/datatable/urls/")}}/'+data.id,
             columns: [
                   {
                        data: 'id',
                         name: 'id',
                        "searchable": false,
                        "orderable": false,
                       
                    },
                   
                    {data: 'lander_url', name: 'first_name', orderable: true, searchable: true},
                    {data: 'status', name: 'status', orderable: true, searchable: true},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                order: [0, 'asc'],
            // "oLanguage": {
            //   "sLengthMenu": "_MENU_ records per page"
            // }
          });

        details_editor[tableId] = new $.fn.dataTable.Editor({
                    ajax: '{{url("/lander-url/editor")}}',
                    table: $('#'+tableId),
                    fields:[
                        {label: "Lander URL", name: "lander_url", type: 'text', options: []},
                       
                        ] ,
                    idSrc: 'id',
                });
         $('#' + tableId).on('click', 'tbody td:not(:first-child)', function (e) {
             if (e.toElement.cellIndex > 0 && e.toElement.cellIndex < 2) {
                      
                     
                        details_editor[tableId].inline(this);
                }
         });
          table_template[tableId].on( 'order.dt search.dt', function () {
               table_template[tableId].column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();
    }
    
    </script>
     <!-- Vue scripts required by this view -->
   <script src="/js/vue/lander.js"></script>
   <script id="contacts-attach-list" type="text/x-handlebars-template">
              @include('lander.child-contact',['id'=>'detail-@{{id}}','title'=>'Url Attach of this Lander'])
              
    </script>
   
@endsection