@extends('layouts.app')

@section('title', 'Cập Nhật User')

@section('content-header', 'User')

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
                    <h3 class="box-title">Cập Nhật User</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ action('UserController@update', $user->id) }}" method="POST">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="@if(old('name')){{ old('name') }}@else{{ $user->name }}@endif">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>

                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="email" value="@if(old('email')){{ old('email') }}@else{{ $user->email }}@endif">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-sm-2 control-label">Password</label>

                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="password" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="confirm-password" class="col-sm-2 control-label">Confirm Password</label>

                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="confirm-password" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="col-sm-2 control-label">Phone</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="phone" value="@if(old('phone')){{ old('phone') }}@else{{ $user->phone }}@endif">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address" class="col-sm-2 control-label">Address</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="address" value="@if(old('address')){{ old('address') }}@else{{ $user->address }}@endif">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="roles[]" class="col-sm-2 control-label">Role</label>

                            <div class="col-sm-10">
                                @foreach($roles as $role)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="roles" value="{{ $role->id }}" @if($user->hasRole($role->name)) {!! 'checked' !!} @endif>
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
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