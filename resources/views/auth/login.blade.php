@extends('layouts.auth')

@section('content')
    <div class="login-box-body animated bounceIn">
        <p class="login-box-msg">Đăng nhập hệ thống</p>

        <form action="{{ url('/login') }}" method="post">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('username') ? ' has-error animated shake' : '' }} has-feedback">
                <input type="text" name="username" class="form-control" placeholder="ID" value="{{ old('username') }}" required autofocus>

                @if ($errors->has('username'))
                    <span class="help-block">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                @endif

                <span class="fa fa-id-card-o form-control-feedback"></span>
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

            <div class="row">
                <div class="col-xs-7">
                    <div class="checkbox icheck">
                        <label> <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me </label><br>
                    </div>
                </div>
                <!-- /.col -->

                <div class="col-xs-5">
                    <button type="submit" class="btn btn-primary btn-block btn-flat ripple">Đăng Nhập</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <a href="{{ url('/password/reset') }}" class="ripple">Quên mật khẩu?</a>
    </div>
    <!-- /.login-box-body -->
@endsection