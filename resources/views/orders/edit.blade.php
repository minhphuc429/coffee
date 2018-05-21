@extends('layouts.app')

@section('title', 'Cập Nhật Đơn Hàng')

@section('stylesheet')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
@endsection

@section('content-header', 'Cập Nhật Đơn Hàng')

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
    @php
        //dd($deliver_id)
    @endphp
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
        {{ Form::open(['route' => [ 'orders.update', $order->id ], 'method' => 'PUT']) }}
            <div class="form-group">
                <label for="deliver_id">Người giao hàng</label>
                <select name="deliver_id" id="deliver_id" class="form-control select2">
                    <option value="0">- Chọn người giao hàng -</option>
                    @foreach($delivers as $deliver)
                    <option value="{{$deliver->id}}">{{$deliver->name}}</option>
                    @endforeach

                    <script>
                        var elmnt = document.getElementById("deliver_id");
                        var value = {{ $deliver_id }};
                        for(var i=0; i < elmnt.options.length; i++)
                        {
                            if(elmnt.options[i].value == value)
                                elmnt.selectedIndex = i;
                            else elmnt.selectedIndex = 0;
                        }
                    </script>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Trạng thái</label>
                {{ Form::select('status', $status, $order->status, ['class' => 'form-control select2', 'id' => 'status']) }}
            </div>

            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-xs btn-default">Hủy</a>
            <button type="submit" class="btn btn-xs btn-success pull-right">Cập Nhật</button>
            {{ Form::close() }}
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            Người đặt hàng
            <address>
                <strong>{{ $order->customer_name }}</strong><br>
                Địa chỉ: {{ $order->customer_address }}<br>
                Điện thoại: {{ $order->customer_phone }}<br>
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            Người nhận hàng
            <address>
                <strong>{{ $order->customer_name }}</strong><br>
                Địa chỉ giao hàng: {{ $order->customer_address }}<br>
                Điện thoại: {{ $order->customer_phone }}<br>
            </address>
        </div>
        <!-- /.col -->
    </div>

    <div class="row">
        <div class="col-sm-12 invoice-col">
            <div class="box">
                <div class="box-body no-padding">
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <th class="text-center">Số lượng</th>
                            <th>Tên sản phẩm</th>
                            <th class="text-center">Đơn giá</th>
                            <th class="text-center">Tổng cộng</th>
                        </tr>
                        @foreach($order->products as $product)
                            <tr>
                                <td class="text-center">{{ $product->pivot->quantity }}</td>
                                <td>{{ $product->name }}</td>
                                <td class="text-center">{{ number_format($product->price, 0, ',', '.') }}đ</td>
                                <td class="text-center">{{ number_format($product->pivot->quantity * $product->price, 0, ',', '.') }}
                                    đ
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="text-center">Tổng cộng:</td>
                            <td class="text-center">{{ number_format($order->subtotal, 0, ',', '.') }}đ</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="text-center">Phí vận chuyển:</td>
                            <td class="text-center">{{ number_format($order->shipping_fee, 0, ',', '.') }}đ</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="text-center">Tất cả:</td>
                            <td class="text-center text-red">{{ number_format($order->total, 0, ',', '.') }}đ</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!-- /.col -->
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