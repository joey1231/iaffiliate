@extends('layouts.app')
@section('content')
    <style>
        .footer, .navbar-default {
            display:none !important;
        }
        .other-text-login {
            text-align: center;
        }


        .register-logo {
            text-align: right;
        }
        .container-full {
            padding:0px;
            width:100%;
        }
        body {
            overflow-x: hidden;
        }

        .col-md-4, .col-md-8 {
            /*border:1px solid red;*/
        }
    </style>



    <div class="row">




        <br><br><Br>
        <div class="col-md-4 register-logo">
             <img src="{{url('/public/img/logo/re design combin-4 color.png')}}" />
        </div>
        <div class="col-md-8 ">
            <div class="row" >
                <div class="col-md-8">

                    <h3>Get started with a free account</h3>

                    <p>
                        Create a free Sendright account to send beautiful emails to customers, contributors, and fans. Already have a Sendright account? <a href="{{url('/login')}}">Log in here</a>
                    </p>

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <div class="col-md-12"> <label class="label label-default" >Name</label> </div>

                    <div class="col-md-12">
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                    <div class="col-md-12"> <label class="label label-default" >E-Mail Address</label> </div>

                    <div class="col-md-12">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <div class="col-md-12"> <label class="label label-default" >Password</label> </div>

                    <div class="col-md-12">
                        <input id="password" type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <div class="col-md-12"> <label class="label label-default" >Confirm Password</label> </div>

                    <div class="col-md-12">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">
                            Register
                        </button>
                    </div>
                    <div class="col-md-8">
                            By clicking this button, you agree to Sendright <a href="#">Anti-spam Policy & Terms of Use</a>.
                    </div>
                </div>
                @include("pages/include/footer/simple-footer")
            </form>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </div>
@endsection
