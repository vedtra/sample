@extends('layouts.auth')

@section('content')
<!-- Advanced login -->
<form role="form" method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}
    <div class="panel panel-body login-form">
        <div class="text-center">
            <div class=""><img src="{{url('/images/logo.png')}}" width="80"></div>
            <h5 class="content-group">Login to your account <small class="display-block">Your credentials</small></h5>
             @if (Session::has('pesan'))
                <span class="help-block">
                    <code> {!!Session::get('pesan')!!}</code>
                </span>
             @endif
        </div>

        <div class="form-group has-feedback has-feedback-left">
            <input type="email" class="form-control" placeholder="E-mail" name="email" value="{{ old('email') }}" required autofocus>
            <div class="form-control-feedback">
                <i class="icon-user text-muted"></i>
            </div>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group has-feedback has-feedback-left">
            <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
            <div class="form-control-feedback">
                <i class="icon-lock2 text-muted"></i>
            </div>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>        
       
        <div class="form-group">
            <button type="submit" class="btn bg-dark-blue btn-block">Login</i></button>
        </div>       

        <!-- <div class="content-divider text-muted form-group"><span>Don't have an account?</span></div>
        <a href="{{url('/register')}}" class="btn btn-default btn-block content-group">Sign up</a> -->
        <span class="help-block text-center no-margin">By continuing, you're confirming that you've read our <a href="#">Terms &amp; Conditions</a> and <a href="#">Cookie Policy</a></span>
    </div>
</form>

@endsection
