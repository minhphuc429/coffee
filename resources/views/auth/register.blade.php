@extends('layouts.auth')

@section('content')
    <div class="login-box-body animated bounceIn">
        <p class="login-box-msg">Đăng ký thành viên</p>

        <form action="{{ url('/register') }}" method="post">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('name') ? ' has-error animated shake' : '' }} has-feedback">
                <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}" required autofocus>

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif

                <span class="fa fa-user form-control-feedback"></span>
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error animated shake' : '' }} has-feedback">
                <input type="email" name="email" class="form-control" placeholder="E-Mail Address" required>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif

                <span class="fa fa-envelope form-control-feedback"></span>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error animated shake' : '' }} has-feedback">
                <input type="password" name="password" class="form-control" placeholder="Password" required>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif

                <span class="fa fa-key form-control-feedback"></span>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error animated shake' : '' }} has-feedback">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>

                <span class="fa fa-sign-out form-control-feedback"></span>
            </div>

            <div class="row">
                <div class="col-xs-7">
                </div>
                <!-- /.col -->

                <div class="col-xs-5">
                    <button type="submit" class="btn btn-primary btn-block btn-flat ripple">Register</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
    <!-- /.login-box-body -->
@endsection
