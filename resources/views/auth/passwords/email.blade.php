@extends('layouts.app')

<!-- Main Content -->
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
        .forgot-logo, .title {
            text-align: center;
        }
    </style>
        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <br><br>
                <div class="forgot-logo">
                    <img src="{{url('/public/img/logo/re design combin-4 color.png')}}" />
                </div>

                <h3 class="title">Reset Password</h3>

                <br>
                <div>
                    Fear not. We’ll email you instructions to reset your password.  If you don’t have access to your email anymore, you can try account recovery.
                </div>
                <br>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                    {{ csrf_field() }}

                    <br>
                    <div class="{{ $errors->has('email') ? ' has-error' : '' }}">
                        <div > <label class="label label-default" >E-Mail Address</label> </div>
                        <div >
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">
                                Send Password Reset Link
                            </button>
                        </div>
                        <div class="col-md-6"><a href="{{url('/login')}}">Return to login</a></div>
                    </div>
                </form>


                @include("pages/include/footer/simple-footer")

            </div>
            <div class="col-md-4">
            </div>
        </div>



@endsection
