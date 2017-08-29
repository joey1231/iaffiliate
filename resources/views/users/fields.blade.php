<div class="card-block">
                                    <form action="" method="post">
                                     <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">Name</span>
                                                <input id="username3" name="username3" class="form-control" type="text" v-model="user.name" :disabled="submitting" >
                                                <span class="input-group-addon"><i class="fa fa-user"></i>
                                                </span>
                                            </div>
                                        </div>
                                      <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">Email</span>
                                                <input id="username3" name="username3" class="form-control" type="email" v-model="user.email" :disabled="submitting" >
                                                <span class="input-group-addon"><i class="fa fa-user"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">Password</span>
                                                <input id="username3" name="username3" class="form-control" type="password" v-model="user.password" :disabled="submitting" >
                                                <span class="input-group-addon"><i class="fa fa-user"></i>
                                                </span>
                                            </div>
                                        </div>
                            
                                        
                                        <hr/>
                                       
                                        
                                       <div class="sk-wave" v-show="submitting">
                                        <div class="sk-rect sk-rect1"></div>
                                        <div class="sk-rect sk-rect2"></div>
                                        <div class="sk-rect sk-rect3"></div>
                                        <div class="sk-rect sk-rect4"></div>
                                        <div class="sk-rect sk-rect5"></div>
                                    </div>
                                    </form>
                                </div>