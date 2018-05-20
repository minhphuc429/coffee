@extends('orders.layout')
@section('styles')
    <style>
        .more-info {

        }

        .product-price {
            color: #206b9b;
            font-size: 16px;
            font-family: NotoSans-Bold, serif;
            font-weight: 400;
        }

        .btn-adding {
            width: 22px;
            height: 22px;
            text-align: center;
            line-height: 22px;
            font-size: 20px;
            color: #fff;
            font-weight: 700;
            border-radius: 4px;
            -moz-border-radius: 4px;
            -webkit-border-radius: 4px;
            background-color: #cf2127;
            display: inline-block;
            margin-left: 10px;
            cursor: pointer !important;
            outline: 0;
        }
    </style>
@endsection
@section('body_tag', 'data-spy=scroll data-target=#menu data-offset=100')
@section('content')
    <div class="container" style="margin-top:100px">

        <!-- Modal Limit Buy -->
        <div id="modal_add_product" class="modal fade bw-modal-confirm">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="media">
                            <div class="media-left">
                                <img src="" class="media-object" style="width:60px">
                            </div>
                            <div class="media-body">
                                <div class="row">
                                    <div class="col-md-9">
                                        <h4 class="media-heading"></h4>
                                        <span class="txt-blue product-price">đ</span>
                                    </div>
                                    <div class="col-md-3 more-info">
                                        <input type="hidden" id="product_id">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <!-- Chọn Size -->
                        <div class="form-group">
                            <label for="sizes[]">Chọn Size</label>
                            <div id="pick_size">

                            </div>
                        </div>

                        <!-- Chọn Số Lượng -->
                        <div class="form-group form-inline">
                            <label for="qty">Số Lượng</label>
                            <input type="number" class="form-control" name="qty" value="1" step="1" max="100">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="add_to_cart"
                                data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processing Order">
                            Thêm vào giỏ hàng
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="">
            <!-- thực đơn -->
            <ul class="nav nav-pills nav-stacked col-md-3">
                @foreach($categories as $key => $category)
                    <li @if($key == 0)class="active" @endif><a data-toggle="pill"
                                                               href="#section{{ $category->id }}">{{ $category->name }}</a>
                    </li>
                @endforeach
            </ul>

            <!-- sản phầm -->
            <div class="tab-content col-md-9">
                @foreach($categories as $key => $category)
                    <div id="section{{ $category->id }}"
                         class="tab-pane fade in <?php if ($key == 0) echo 'active'; ?>">
                        @foreach($category->products as $product)
                            <div class="media">
                                <div class="media-left">
                                    <img src="{{ asset(Storage::url($product->image)) }}" class="media-object"
                                         style="width:60px">
                                </div>
                                <div class="media-body">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h4 class="media-heading">{{ $product->name }}</h4>
                                        </div>
                                        <div class="col-md-3 more-info">
                                            <input type="hidden" value="{{ $product->id }}">
                                            <span class="txt-blue product-price">{{ $product->price }}đ</span>
                                            <span class="btn-adding">+</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('.btn-adding').click(function (e) {
                let product_id = $(this).siblings('input:hidden').val();
                let product_image = $(this).parents('.media').find("img").attr('src');
                let product_name = $(this).parents('.media').find("h4.media-heading").text();
                let product_price = $(this).parents('.media').find("span.product-price").text();

                $('#modal_add_product #product_id').val(product_id);
                $('#modal_add_product img').attr("src", product_image);
                $('#modal_add_product h4.media-heading').text(product_name);
                $('#modal_add_product span.product-price').text(product_price);
                $('#modal_add_product input[name="qty"]').val(1);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                });

                $.ajax({
                    context: $(this),
                    url: '{{ url('get-product-options') }}',
                    type: 'post',
                    data: {
                        'product_id': product_id,
                        '_token': $('input[name=_token]').val()
                    },
                    dataType: 'json',
                    success: function (data) {
                        //console.log(data);
                        $('#pick_size').find('label').remove();
                        $.each(data, function (i, product_option) {
                            let surcharge_elm = '';
                            if (product_option.surcharge !== 0) surcharge_elm = '(+' + product_option.surcharge + 'đ)';
                            $('#pick_size').append('<label class="radio-inline"><input type="radio" name="sizes[]" value="' + product_option.id + '">' + product_option.value + '\n'
                                + surcharge_elm + '</label>'); //add input box
                        });
                        $("#pick_size input[type=radio]:first").prop("checked", true);
                        $("#modal_add_product").modal("show");
                    },
                    error: function (error) {
                        console.log(error.responseJSON)
                    }
                });
            });

            $('#add_to_cart').click(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                });

                $.ajax({
                    context: $(this),
                    url: '{{ url('order/InsertShoppingCartItem') }}',
                    type: 'post',
                    data: {
                        'product_id': $('#modal_add_product #product_id').val(),
                        'product_option_id': $("input[type='radio']:checked").val(),
                        'qty': $("input[name=qty]").val(),
                        '_token': $('input[name=_token]').val()
                    },
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        $("#modal_add_product").modal("hide");
                    },
                    error: function (error) {
                        console.log(error.responseJSON)
                    }
                });
            });
        });
    </script>
@endsection