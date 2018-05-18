@extends('layouts.app')

@section('stylesheet')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
@endsection

@section('title', 'Thêm Sản Phẩm')

@section('content-header', 'Thêm Sản Phẩm')

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
                    <h3 class="box-title">Nhập Thông Tin Sản Phẩm</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ action('ProductController@store') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name" class="col-md-2 control-label">Tên Sản Phẩm</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" placeholder="">
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
                                <input type="number" class="form-control" name="price" placeholder="">
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
                        <div class="form-group">
                            <label for="values[]" class="col-md-2 control-label">Size</label>
                            <div class="col-sm-10">
                                <button type="button" class="btn btn-success btn-flat add_form_field"><i class="fa fa-plus" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a href="{{ action('ProductController@index') }}" class="btn btn-default">Trở lại</a>
                        <button type="submit" class="btn btn-success pull-right">Thêm</button>
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

            var x = 0;
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