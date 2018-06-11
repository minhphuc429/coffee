@extends('carts.layout')
@section('styles')
@endsection

@section('content')
    <div class="container" style="margin-top:100px">
        <div class="row">
            <div class="col-sm-12 col-md-10 col-md-offset-1">
                <h3>Chi tiết đơn hàng</h3>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th class="text-center">Đơn giá</th>
                        <th class="text-center">Thành tiền</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($carts as $row)
                        <tr id="{{ $row->rowId }}">
                            <td class="col-sm-8 col-md-6">
                                <div class="media">
                                    <div class="pull-left">
                                        <img class="thumbnail" src="{{ asset(Storage::url($products[$row->id]->image)) }}" style="height: 60px; width: 60px">
                                    </div>

                                    <div class="media-body">
                                        <h4 class="media-heading">{{ $row->name }}</h4>
                                        <span class="text-success"><strong>@php echo ($row->options->has('size') ? $row->options->size : ''); @endphp</strong></span>
                                    </div>
                                </div>
                            </td>
                            <td class="col-sm-1 col-md-1" style="text-align: center">
                                <input type="number" class="form-control" value="{{ $row->qty }}" min="1" max="100">
                            </td>
                            <td class="col-sm-1 col-md-1 text-center"><strong>{{ $row->price }}đ</strong></td>
                            <td class="col-sm-1 col-md-1 text-center"><strong class="subtotal">{{ $row->total }}đ</strong></td>
                            <td class="col-sm-1 col-md-1">
                                <button type="button" class="btn btn-danger btn-sm">
                                    <span class="glyphicon glyphicon-trash text-center"></span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><h5 class="text-center">Cộng</h5></td>
                        <td><h5 class="text-center"><strong id="total">{{ $total }}đ</strong></h5></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <a href="{{ url('order') }}" type="button" class="btn btn-default">
                                <span class="glyphicon glyphicon-shopping-cart"></span> Tiếp tục đặt hàng
                            </a>
                        </td>
                        <td>
                            @if($total !== 0)
                            <a type="button" class="btn btn-success" href="{{ url('order/completion') }}">
                                Thanh toán <span class="glyphicon glyphicon-play"></span>
                            </a>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- DataTables -->
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("input[type='number']").bind('keyup change', function () {
                let input_qty = $(this);
                let rowId = input_qty.parents('tr').attr('id');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                });

                $.ajax({
                    url: '{{ url('order/UpdateShoppingCartItem') }}',
                    type: 'post',
                    data: {
                        'rowId': rowId,
                        'qty': $(this).val(),
                        '_token': $('input[name=_token]').val()
                    },
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        input_qty.parents('tr').find('strong.subtotal').text(data.carts[rowId].subtotal + 'đ');
                        $('#total').text(data.total + 'đ')
                    },
                    error: function (error) {
                        console.log(error.responseJSON)
                    }
                });
            });

            $('button.btn-danger').click(function () {
                let tr = $(this).parents('tr');
                let rowId = tr.attr('id');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                });

                $.ajax({
                    context: $(this),
                    url: '{{ url('order/RemoveShoppingCartItem') }}',
                    type: 'post',
                    data: {
                        'rowId': rowId,
                        '_token': $('input[name=_token]').val()
                    },
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        tr.remove();
                        $('strong#total').text(data.total + 'đ');
                        $('#item_count').text(data.count);
                    },
                    error: function (error) {
                        console.log(error.responseJSON)
                    }
                });
            });
        })
    </script>
@endsection