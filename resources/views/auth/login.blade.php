@extends('layouts.app')

@section('content')

<div class="login-box">
    <div class="login-logo">
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <h2>Balinese Classic</h2>
        <p>Login to continue</p>

        <form action="{{ route('login') }}" method="post">
            @csrf
        <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
            <input type="email" name="email" class="form-control " value="{{ old('email') }}" placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            @if ($errors->has('email'))
                <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
            @endif

        </div>
        <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
            <input type="password" name="password" class="form-control" value="{{ old('password') }}" placeholder="Password" >
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            @if ($errors->has('password'))
                <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
            @endif
        </div>
        <div class="row">
            <div class="col-xs-8">
            <div class="checkbox icheck">
                <label>
                <input type="checkbox"> Remember Me
                </label>
            </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div>
            <!-- /.col -->
        </div>
        </form>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection
