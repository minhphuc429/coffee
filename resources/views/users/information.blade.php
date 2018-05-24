@extends('layouts.app')

@section('title', 'Thông tin cơ bản')

@section('content-header', 'Thông tin tài khoản')

@section('content')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul class="fa-ul">
                @foreach ($errors->all() as $error)
                    <li><i class="fa-li fa fa-chevron-circle-right"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin tài khoản</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ action('UserController@updateInformation') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Tên</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" value="@if(old('name')){{ old('name') }}@else{{ $user->name }}@endif">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>

                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="email" name="email" value="@if(old('email')){{ old('email') }}@else{{ $user->email }}@endif">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="col-sm-2 control-label">Điện thoại</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="phone" name="phone" value="@if(old('phone')){{ old('phone') }}@else{{ $user->phone }}@endif">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address" class="col-sm-2 control-label">Địa chỉ</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="address" name="address" value="@if(old('address')){{ old('address') }}@else{{ $user->address }}@endif">
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a href="{{ route('users.index') }}" class="btn btn-default">Trở lại</a>
                        <button type="submit" class="btn btn-success pull-right">Cập Nhật</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
    </div>
@endsection