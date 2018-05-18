@extends('layouts.app')

@section('stylesheet')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
@endsection

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
                <form class="form-horizontal" action="{{ action('ProductController@update', $product->id) }}" method="POST">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="name" class="col-md-2 control-label">Tên Sản Phẩm</label>

                        <div class="col-md-10">
                            <input type="text" class="form-control" name="name" placeholder="" value="@if(old('name')){{ old('name') }}@else{{ $product->name }}@endif">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image" class="col-md-2 control-label">Hình Ảnh</label>

                        <div class="col-sm-10">
                            <input type="file" name="image" accept="image/*">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="price" class="col-md-2 control-label">Giá</label>

                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="price" placeholder="" value="@if(old('price')){{ old('price') }}@else{{ $product->price }}@endif">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category_id" class="col-md-2 control-label">Danh mục</label>

                        <div class="col-md-10">
                            <select name="category_id" class="form-control select2">
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a href="{{ route('products.index') }}" class="btn btn-default">Trở lại</a>
                        <button type="submit" class="btn btn-success pull-right">Cập Nhật</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Select2 -->
    <script src="{{ asset('adminlte/plugins/select2/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2();


        });
    </script>
@endsection