@extends('orders.layout')
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
    <style>
        #map {
            height: 300px;
        }
    </style>

@endsection

@section('content')
    <div class="container" style="margin-top:100px">
        <div class="row">
            <div class="col-md-6">
                <div id="map"></div>

                {{ Form::open(['url' => 'order/completion', 'class' => 'form']) }}

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <input type="hidden" name="subtotal" value="{{ $total }}">
                <input type="hidden" name="shipping_fee">
                <input type="hidden" name="total">

                <div class="form-group" style="margin-bottom: 0;">
                    <label for="customer_name">Thông tin người nhận</label>
                </div>
                <div class="row form-group">
                    <div class="col-xs-6 col-md-6">
                        <input type="text" name="customer_name" id="customer_name" class="form-control"
                               placeholder="Họ tên" required autofocus>
                    </div>
                    <div class="col-xs-6 col-md-6">
                        <input class="form-control" name="customer_phone" placeholder="Điện thoại" type="text"
                               required/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="delivery_time">Chọn thời gian giao hàng</label>
                    {{ Form::select('time', $halfHourIntervals, null, ['class' => 'form-control select2', 'name' => 'delivery_time']) }}
                </div>

                <div class="form-group">
                    <label for="customer_address">Địa điểm giao hàng</label>
                    <input id="autocomplete" name="customer_address" class="form-control" placeholder="Địa chỉ"
                           onFocus="geolocate()" type="text"/>
                </div>
                <div class="form-group">
                    <label for="payment_method">Phương thức thanh toán</label>
                    <select class="form-control" name="payment_method" id="payment_method">
                        <option value="COD">Tiền mặt</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success pull-right">Hoàn tất đơn hàng</button>

                {{ Form::close() }}
            </div>

            <div class="col-md-6">
                <div id="row">
                    <div>
                        <strong>Results</strong>
                    </div>
                    <div id="output"></div>
                </div>

                <h5>Chi tiết đơn hàng</h5>
                <table class="table table-hover">
                    @foreach($carts as $row)
                        <tr>
                            <td class="col-sm-8 col-md-10">
                                <h5>
                                    <span class="badge"
                                          style="padding-bottom: 0;">{{ $row->qty }}</span> {{ $row->name }}
                                    [@php echo ($row->options->has('size') ? $row->options->size : ''); @endphp]
                                </h5>
                            </td>
                            <td class="col-md-2 text-right"><h5>{{ number_format($row->total, 0, ',', '.') }}
                                    đ</h5></td>
                        </tr>
                    @endforeach
                    <tr>
                        <td><h5>Cộng</h5></td>
                        <td class="text-right">
                            <h5><strong class="subtotal">{{ number_format($total, 0, ',', '.') }}đ</strong></h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>Phí vận chuyển:
                                <span class="distance text-danger"></span>
                            </h5>
                        </td>
                        <td class="col-sm-1 col-md-1 text-right"><h5><strong class="shipping_fee"></strong></h5></td>
                    </tr>
                    <tr>
                        <td><h5>Tạm tính:</h5></td>
                        <td class="col-sm-1 col-md-1 text-right"><h5><strong class="total"></strong></h5></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $('.select2').select2();

        //////////////////////////////////// Place Autocomplete Address Form  //////////////////////////////////////////

        const origin = {lat: 16.060766, lng: 108.221237}; // Gong Cha 29 Nguyễn Văn Linh, Bình Hiên, Hải Châu, Đà Nẵng, Việt Nam
        var destination;
        var directionsService, directionsDisplay, map;
        var autocomplete;
        var shipping_fee;

        const numberWithCommas = (x) => {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        };

        function initMap() {
            // Create the autocomplete object, restricting the search to geographical
            // location types.
            autocomplete = new google.maps.places.Autocomplete((document.getElementById('autocomplete')), {
                types: ['geocode'],
                componentRestrictions: {
                    country: "vn"
                }
            });

            var onChangeHandler = function () {
                calculateAndDisplayRoute(directionsService, directionsDisplay);
                distanceMatrixService()
            };

            // When the user selects an address from the dropdown, populate the address
            // fields in the form.
            autocomplete.addListener('place_changed', onChangeHandler);

            // initDirectionsService
            directionsService = new google.maps.DirectionsService;
            directionsDisplay = new google.maps.DirectionsRenderer;
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 17,
                center: origin
            });
            directionsDisplay.setMap(map);
        }

        // Bias the autocomplete object to the user's geographical location,
        // as supplied by the browser's 'navigator.geolocation' object.
        function geolocate() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    var circle = new google.maps.Circle({
                        center: geolocation,
                        radius: position.coords.accuracy
                    });
                    autocomplete.setBounds(circle.getBounds());
                });
            }
        }

        ////////////////////////////////////// Distance Matrix service /////////////////////////////////////////////////

        function distanceMatrixService() {
            destination = autocomplete.getPlace().formatted_address;

            var service = new google.maps.DistanceMatrixService;
            service.getDistanceMatrix({
                origins: [origin],
                destinations: [destination],
                travelMode: 'DRIVING',
                unitSystem: google.maps.UnitSystem.METRIC,
                avoidHighways: false,
                avoidTolls: false
            }, function (response, status) {
                if (status !== 'OK') {
                    alert('Error was: ' + status);
                } else {
                    var outputDiv = document.getElementById('output');
                    outputDiv.innerHTML = '';
                    var originList = response.originAddresses;
                    for (var i = 0; i < originList.length; i++) {
                        var results = response.rows[i].elements;
                        for (var j = 0; j < results.length; j++) {
                            //outputDiv.innerHTML += results[j].distance.text + ' in ' + results[j].duration.text + '<br>';
                            let distance = (results[j].distance.value / 1000).toFixed(1);
                            shipping_fee = distance * 5000;
                            let total = Number($('input[name="subtotal"]').val()) + shipping_fee;
                            $('input[name="total"]').val(total);
                            $('input[name="shipping_fee"]').val(shipping_fee);
                            $('.distance').text(distance + 'km');
                            $('.shipping_fee').text(numberWithCommas(shipping_fee) + 'đ');
                            $('.total').text(numberWithCommas(total) + 'đ')
                        }
                    }
                }
            });
        }

        //////////////////////////////////////  Directions service  ////////////////////////////////////////////////////

        function calculateAndDisplayRoute(directionsService, directionsDisplay) {
            destination = autocomplete.getPlace().formatted_address;

            directionsService.route({
                origin: origin,
                destination: destination,
                travelMode: 'DRIVING'
            }, function (response, status) {
                if (status === 'OK') {
                    directionsDisplay.setDirections(response);
                } else {
                    window.alert('Directions request failed due to ' + status);
                }
            });
        }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0AyZ_OqRmV5GsK-H66L5vKgU3u8Uxvs4&libraries=places&language=vi&region=vn&callback=initMap"
            async defer></script>
@endsection