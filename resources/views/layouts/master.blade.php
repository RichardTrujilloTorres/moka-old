<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>{{ config('app.name') }}</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap core CSS     -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="/assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="/assets/css/paper-dashboard.css" rel="stylesheet"/>

    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="/assets/css/demo.css" rel="stylesheet" />

    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="/assets/css/themify-icons.css" rel="stylesheet">

</head>
<body>

<div class="wrapper">
	<div class="sidebar" data-background-color="black" data-active-color="success">

    <!--
		Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
		Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
	-->

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="{{ url('/') }}" class="simple-text">
                    {{ config('app.name') }}
                </a>
            </div>

            <ul class="nav">

                @if (Route::is('admin.dashboard'))
                <li class="active">
                @else
                <li>
                @endif
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="ti-pie-chart"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @if (Route::is('admin.users.*') || Route::is('admin.users'))
                <li class="active">
                @else 
                <li>
                @endif
                    <a href="{{ route('admin.users') }}">
                        <i class="ti-user"></i>
                        <p>Users</p>
                    </a>
                </li>

                @if (Route::is('admin.roles.*') || Route::is('admin.roles'))
                <li class="active">
                @else 
                <li>
                @endif
                    <a href="{{ route('admin.roles') }}">
                        <i class="ti-lock"></i>
                        <p>Roles</p>
                    </a>
                </li>

            </ul>
    	</div>
    </div>

    <div class="main-panel" id="app">

    @include('partials._navbar')
        <div class="content">
            <div class="container-fluid">
                <div class="row">

                    @yield('content')

                </div>
            </div>
        </div>


        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>

                        <li>
                            <a href="{{ url('/') }}">
                                Home
                            </a>
                        </li>
                    </ul>
                </nav>
				<div class="copyright pull-right">
                    &copy; 2018, made with <i class="fa fa-coffee cofee"></i> by <a href="">Richard Trujillo</a>
                    {{-- 
                    &copy; <script>document.write(new Date().getFullYear())</script>, made with <i class="fa fa-coffee cofee"></i> by <a href="">Richard Trujillo</a>
                    --}}
                </div>
            </div>
        </footer>

    </div>
</div>


@yield('partials')

</body>

    <!--   Core JS Files   -->
    <script src="/assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="/assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="/assets/js/bootstrap-checkbox-radio.js"></script>

	<!--  Charts Plugin -->
	<!-- <script src="/assets/js/chartist.min.js"></script> -->

    <!--  Notifications Plugin    -->
    <script src="/assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script> -->

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
	<script src="/assets/js/paper-dashboard.js"></script>

	<!-- Paper Dashboard DEMO methods, don't include it in your project! -->
	<script src="/assets/js/demo.js"></script>


    @if (Route::is('admin.dashboard'))
	<script type="text/javascript">
    	$(document).ready(function(){
        	demo.initChartist();
    	});
	</script>
    @endif

    @if (session('message'))
	<script type="text/javascript">
    	$(document).ready(function(){

        	// demo.initChartist();

        	$.notify({
            	icon: 'ti-check',
            	message: "{{ session('message') }}"

            },{
                type: '{{ session('status') }}',
                timer: 4000
            });

    	});
	</script>
    @endif

</html>
