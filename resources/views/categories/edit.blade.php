@extends('layouts.app')

@section('title', 'Cập Nhật Danh Mục Sản Phẩm')

@section('content-header', 'Danh Mục Sản Phẩm')

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
                    <h3 class="box-title">Cập Nhật Danh Mục Sản Phẩm</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ action('CategoryController@update', $category->id) }}" method="POST">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="name" class="col-md-2 control-label">Tên Danh Mục</label>

                        <div class="col-md-10">
                            <input type="text" class="form-control" name="name" placeholder="" value="@if(old('name')){{ old('name') }}@else{{ $category->name }}@endif">
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a href="{{ route('categories.index') }}" class="btn btn-default">Trở lại</a>
                        <button type="submit" class="btn btn-success pull-right">Cập Nhật</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
    </div>
@endsection