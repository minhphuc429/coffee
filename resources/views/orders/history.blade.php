@extends('layouts.app')

@section('title', 'Danh Sách Đơn Hàng')

@section('stylesheet')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
@endsection

@section('content-header', 'Danh Sách Đơn Hàng')

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
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <table id="data-table" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Mã order</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Chi tiết</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($orders as $order)
                            <tr id="{{ $order->id }}">
                                <td>{{ ++$i }}</td>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->created_at }}</td>
                                <td>{{ number_format($order->total, 0, ',' , '.') }}đ</td>
                                <td><label for="" class="badge">{{ $order->status }}</label></td>
                                <td>

                                    <a href="{{ route('order.detail', $order->id) }}">Xem chi tiết</a>
                                    @if($order->status == 'processing' )
                                        {{ Form::open(['route' => [ 'order.cancel' ]]) }}
                                        <input type="hidden" value="{{ $order->id }}" name="order_id">
                                        {{ Form::submit('Hủy đơn hàng', ['class' => 'btn btn-xs btn-danger']) }}
                                        {{ Form::close() }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal-delete" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Xác nhận hủy?</h4>
                </div>
                <div class="modal-body">
                    <p>Đơn hàng <b class="message"></b> sẽ bị hủy.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default ripple" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-google ripple" data-id="">Đồng ý</button>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <!-- DataTables -->
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $(function () {
            $('#data-table').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": false,
                "autoWidth": true
            });

            $('#modal-delete').on('show.bs.modal', function (e) {
                let data = $(e.relatedTarget).data();
                $('.message', this).text(data.message);
                $('.btn-google', this).data('id', data.id);
            });

            $('.modal-footer').on('click', '.btn-google', function (e) {
                e.preventDefault();
                $(".btn-google").prop('disabled', true);
                let id = $(this).data('id');

                $.ajax({
                    type: "post",
                    url: '{{ action('OrderController@cancelOrder') }}',
                    data: {
                        'order_id': id,
                        '_token': "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                    success: function (data) {
                        $('table#data-table tr#' + id).remove();
                        $('#modal-delete').modal('toggle');
                        $(".btn-google").prop('disabled', false);
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });
        });
    </script>

@endsection