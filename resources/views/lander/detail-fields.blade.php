<div class="card-block">
                                    <form action="" method="post" id="@{{id}}">

                                        <div class="form-group"  style="display:block; margin: 1em">
                                            <div class="input-group">
                                                <span class="input-group-addon">URL</span>
                                                <input id="username3" name="username3" class="form-control url_@{{id}}" type="text" >
                                                
                                                </span>
                                            </div>
                                        </div>
                                         <div class="form-group"  style="display:block; margin: 1em">
                                            <div class="input-group">
                                                <span class="input">Set Active to Voluum</span>
                                                <input id="username3" name="status" class="form-control status_@{{id}}" type="checkbox" value='1' >
                                                
                                                </span>
                                            </div>
                                        </div>
                                       
                                        <hr/>
                                       
                                        
                                       <div class="sk-wave hide_@{{id}} " >
                                        <div class="sk-rect sk-rect1"></div>
                                        <div class="sk-rect sk-rect2"></div>
                                        <div class="sk-rect sk-rect3"></div>
                                        <div class="sk-rect sk-rect4"></div>
                                        <div class="sk-rect sk-rect5"></div>
                                        </div>
                                    </form>
                                </div>
                                       <div class="form-group" style="display:block; margin: 1em">
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                          <button type="button" class="btn btn-primary save-person" id="@{{id}}">Save changes</button>
                                        </div>
                                <script type="text/javascript">
                                    var skwave =$('.hide_@{{id}}').hide();

            
                                </script>