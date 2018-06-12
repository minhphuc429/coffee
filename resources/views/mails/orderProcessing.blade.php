<!DOCTYPE html>
<html>
<head>
    <title>Order Processing</title>
</head>

<body>
<h2>Yêu cầu đặt hàng đã được tiếp nhận</h2>
<br/>
{{ $name }} thân mến,
<br/>
Yêu cầu đặt hàng cho đơn hàng #{{ $order['id'] }} của bạn đã được tiếp nhận, thời gian giao hàng
là <b>{{ $order['delivery_time'] }}</b> với hình thức thanh toán là <b>{{ $order['payment_method'] }}</b>. Chúng tôi sẽ
tiếp tục cập
nhật với bạn về trạng thái tiếp theo của đơn hàng.
</body>

</html>