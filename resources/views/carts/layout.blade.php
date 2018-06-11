<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#00a300">
    <meta name="theme-color" content="#ffffff">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans:400,700" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        body {
            font-family: Notosans, Arial, sans-serif;
        }

        ul.dropdown-cart {
            min-width: 250px;
        }

        ul.dropdown-cart li .item {
            display: block;
            padding: 3px 10px;
            margin: 3px 0;
        }

        ul.dropdown-cart li .item:hover {
            background-color: #f3f3f3;
        }

        ul.dropdown-cart li .item:after {
            visibility: hidden;
            display: block;
            font-size: 0;
            content: " ";
            clear: both;
            height: 0;
        }

        ul.dropdown-cart li .item-left {
            float: left;
        }

        ul.dropdown-cart li .item-left img,
        ul.dropdown-cart li .item-left span.item-info {
            float: left;
        }

        ul.dropdown-cart li .item-left span.item-info {
            margin-left: 10px;
        }

        ul.dropdown-cart li .item-left span.item-info span {
            display: block;
        }

        ul.dropdown-cart li .item-right {
            float: right;
        }

        ul.dropdown-cart li .item-right button {
            margin-top: 14px;
        }
    </style>
    @yield('styles')

</head>
<body @yield('body_tag')>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Laravel</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="{{ Request::segment(1) === 'order' ? 'active' : null }} "><a href="{{ url('order') }}">Order <span class="sr-only">(current)</span></a></li>
                <li class="{{ Request::segment(1) === 'cart' ? 'active' : null }} "><a href="{{ url('cart') }}">Cart</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <span class="glyphicon glyphicon-shopping-cart"></span> <span id="item_count">{{ $count or '0' }}</span> - Items<span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-cart" role="menu">
                        <li><a class="text-center" href="{{ url('cart') }}">Xem Giỏ Hàng</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

@yield('content')

<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

@yield('script')

</body>
</html>
