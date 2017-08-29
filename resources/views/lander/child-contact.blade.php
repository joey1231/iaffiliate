<div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-align-justify"></i> {{$title}}
                                     <div class="card-actions btn-primary">
                                       <a href="#"  data-toggle="modal" data-target="#secondaryModal-@{{id}}">
                                           <i class="fa fa-plus"></i>
                                        </a>   
                                    </div>
                                </div>
                                 <div class="card-block">
                                    <table class="table table-striped table-bordered datatable"  id='{{$id}}'>
                                        <thead>
                                            <tr>
                                             <th>Counter</th>
                                            
                                                <th>Lander Url</th>
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
<div class="modal fade" id="secondaryModal-@{{id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-info " role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Create Lander URL</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                               @include('lander.detail-fields')
                            </div>
                            
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal --> 