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
                <form class="form-horizontal" action="{{ action('ProductController@update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name" class="col-md-2 control-label">Tên Sản Phẩm</label>

                            <div class="col-md-10">
                                <input type="text" class="form-control" name="name" placeholder="" value="@if(old('name')){{ old('name') }}@else{{ $product->name }}@endif">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image" class="col-md-2 control-label">Hình Ảnh</label>

                            <div class="col-sm-10">
                                <img src="{{ asset(Storage::url($product->image)) }}" alt="" class="image" style="height: 60px; width: 60px">
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
                                {{ Form::select('category_id', $categories, $product->category->id, ['class' => 'form-control select2', 'id' => 'category_id']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-2 control-label">Size</label>
                            <div class="col-sm-10">
                                <button type="button" class="btn btn-success btn-flat add_form_field"><i class="fa fa-plus" aria-hidden="true"></i></button>
                            </div>
                        </div>
                        @foreach($options as $option)
                            <div class="form-group">
                                <label for="" class="col-md-2 control-label"></label>
                                <div class="row col-sm-10">
                                    <div class="col-sm-5">
                                        <input class="form-control" name="values[]" placeholder="Size" type="text" value="{{ $option->value }}">
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="input-group">
                                            <input class="form-control" name="surcharges[]" placeholder="Phụ phí" type="number" value="{{ $option->surcharge }}">
                                            <span class="input-group-btn">
                                      <button type="button" class="btn btn-danger btn-flat delete"><i class="fa fa-minus" aria-hidden="true"></i></button>
                                    </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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

            var max_fields      = 3;
            var wrapper         = $(".box-body");
            var add_button      = $(".add_form_field");

            var x = {{ count($options) }};
            $(add_button).click(function(e){
                e.preventDefault();
                if(x < max_fields){
                    x++;
                    $(wrapper).append('<div class="form-group">\n' +
                        '                            <label for="size[]" class="col-md-2 control-label"></label>\n' +
                        '                            <div class="row col-sm-10">\n' +
                        '                                <div class="col-sm-5">\n' +
                        '                                    <input type="text" class="form-control" name="values[]" placeholder="Size">\n' +
                        '                                </div>\n' +
                        '                                <div class="col-sm-5">\n' +
                        '                                    <div class="input-group">\n' +
                        '                                        <input class="form-control" type="number" name="surcharges[]" placeholder="Phụ phí">\n' +
                        '                                        <span class="input-group-btn">\n' +
                        '                                      <button type="button" class="btn btn-danger btn-flat delete"><i class="fa fa-minus" aria-hidden="true"></i></button>\n' +
                        '                                    </span>\n' +
                        '                                    </div>\n' +
                        '                                </div>\n' +
                        '                            </div>\n' +
                        '                        </div>'); //add input box
                }
            });

            $(wrapper).on("click",".delete", function(e){
                e.preventDefault(); $(this).parents('div.form-group').remove(); x--;
            })
        });
    </script>
@endsection