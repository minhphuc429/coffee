@extends('layouts.app')

@section('title', 'Chi Tiết Đơn Hàng')

@section('content-header', 'Chi Tiết Đơn Hàng')

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

    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-default"><i
                class="glyphicon glyphicon-edit"></i></a>
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            Thông tin đặt hàng
            <address>
                <strong>{{ $order->customer_name }}</strong><br>
                Địa chỉ: {{ $order->customer_address }}<br>
                Điện thoại: {{ $order->customer_phone }}<br>
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            @if($order->deliver_id)
                Người giao hàng
                <address>
                    <strong> {{ $deliver->name }}</strong><br>
                    Điện thoại: {{ $deliver->phone }}
                </address>
            @endif
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