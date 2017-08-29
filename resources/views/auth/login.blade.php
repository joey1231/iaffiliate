@extends('layouts.app-login')
@section('contains')
<div class="row justify-content-center">
            <div class="col-md-5">
             <form class="form-horizontal" role="form" method="POST" action="{{ URL::to('login') }}">
                <div class="card-group mb-0">
                    <div class="card p-2">
                    
                        <div class="card-block">
                         @if($errors->has('email') || $errors->has('password'))
                            <div class="card card-inverse card-danger text-center">
                                <div class="card-block">
                                    <blockquote class="card-blockquote">
                                       @if ($errors->has('email'))
                                        <p>
                                            {{ $errors->first('email') }}
                                        </p>
                                    @endif
                                        @if ($errors->has('password'))
                                        <p>
                                          {{ $errors->first('password') }}
                                        </p>
                                    @endif
                                    </blockquote>
                                </div>
                            </div>
                             @endif
                            <h1>Login</h1>
                              {{ csrf_field() }}
                             
                            <p class="text-muted">Sign In to your account</p>
                            <div class="input-group mb-1">
                                <span class="input-group-addon"><i class="icon-user"></i>
                                </span>
                                <input type="email" class="form-control" placeholder="Username" name="email"
                                           value="{{ old('email') }}" required autofocus>
                                 
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-addon"><i class="icon-lock"></i>
                                </span>
                                <input type="password" class="form-control" placeholder="Password" name="password" required>
                                   
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary px-2">Login</button>
                                </div>
                                <div class="col-6 text-right">
                                    <button type="button" class="btn btn-link px-0">Forgot password?</button>
                                </div>
                            </div>
                        </div>
                    </div>
                   

                </div>
                </form>
            </div>
        </div>
@endsection