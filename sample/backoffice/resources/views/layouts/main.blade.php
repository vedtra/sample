<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{env('APP_NAME','ConioLabs')}}</title>

	<link rel="shortcut icon" href="{{url('/images/favicon.PNG')}}" />
    <link rel="apple-touch-icon" sizes="32x32" href="{{url('/images/favicon.PNG')}}" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{url('/images/favicon.PNG')}}" />
    <link rel="apple-touch-icon" sizes="120x120" href="{{url('/images/favicon.PNG')}}" />
    <link rel="apple-touch-icon" sizes="152x152" href="{{url('/images/favicon.PNG')}}" />

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{url('assets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
	<link href="{{url('assets/css/bootstrap.css')}}" rel="stylesheet" type="text/css">
	<link href="{{url('assets/css/core.css')}}" rel="stylesheet" type="text/css">
	<link href="{{url('assets/css/components.css')}}" rel="stylesheet" type="text/css">
	<link href="{{url('assets/css/colors.css')}}" rel="stylesheet" type="text/css">
	<link href="{{url('assets/css/app.css')}}" rel="stylesheet" type="text/css">
	<link href="{{url('assets/css/custom.css')}}" rel="stylesheet" type="text/css">
	<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
	<!-- /global stylesheets -->
	<script type="text/javascript">
		var base_url = "{{url('')}}";
	</script>
	<!-- Core JS files -->
	<script type="text/javascript" src="{{url('assets/js/plugins/loaders/pace.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/js/core/libraries/jquery.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/js/core/libraries/bootstrap.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/js/plugins/loaders/blockui.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/js/plugins/editors/summernote/summernote.min.js')}}"></script>

	<script type="text/javascript" src="{{url('assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/js/plugins/tables/datatables/extensions/responsive.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/js/pages/datatables_responsive.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/js/validator/validator.min.js')}}"></script>
	<!-- /core JS files -->
</head>

<body>

	<!-- Main navbar -->
	<div class="navbar navbar-inverse large navbar-fixed-top">
		<div class="navbar-header">
			<a class="navbar-brand" href="{{url('/')}}">
				<img src="{{url('/images/header_logo.png')}}" alt="{{env('APP_NAME','Coniolabs')}}">
			</a>

			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>

			<ul class="nav navbar-nav navbar-right">

				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
						@if(Auth::user()->avatar)
							<img src="{{url(''.Auth::user()->avatar)}}" alt="">
						@else
							<img src="{{url('/images/avatar.png')}}" alt="">
						@endif
						<span>Hi, {{@Auth::user()->name}}</span>
						<i class="caret"></i>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						@if(Route::has('formpasswd'))
						<li><a href="{{route('formpasswd')}}"><i class="icon-lock5"></i> Change Pasword</a></li>
						<li class="divider"></li>
						@endif
						<li><a href="{{route('logout')}}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="icon-switch2"></i> Logout</a></li>
                         <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<div class="sidebar sidebar-main dark-blue">
				<div class="sidebar-content">

					<!-- Main navigation -->
					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding" id="dashboard_menu">
							@include('partial/menu')
						</div>
					</div>
					<!-- /main navigation -->

				</div>
			</div>
			<!-- /main sidebar -->


			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header page-header-default">

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="{{route('home')}}"><i class="icon-home2 position-left"></i> Home</a></li>
							@if(@$bread_crumb)
								<li class="active">{{$bread_crumb}}</li>
							@endif
						</ul>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
					@yield('content')
					<!-- Footer -->
					<div class="footer text-muted">
						&copy; {{date('Y')}}. <a href="#">{{env('DEVELOPER_NAME','ConioLabs')}}</a>
					</div>
					<!-- /footer -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->
	<div id="container-modal">

    </div>
	<!-- /page container -->
	<!-- Theme JS files -->
	<script type="text/javascript" src="{{url('assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/js/plugins/forms/selects/select2.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/js/plugins/notifications/pnotify.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/js/plugins/notifications/sweet_alert.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/js/core/app.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/js/pages/datatables_basic.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/js/plugins/buttons/spin.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/js/plugins/buttons/ladda.min.js')}}"></script>

	<script type="text/javascript" src="{{url('assets/js/plugins/ui/moment/moment.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/js/plugins/pickers/daterangepicker.js')}}"></script>

	<!-- /theme JS files -->
	<!-- Highcart -->
	<!-- <script type="text/javascript" src="{{url('assets/js/plugins/highcart/highcharts.js')}}"></script>	 -->
	<!-- <script type="text/javascript" src="{{url('assets/js/plugins/highcart/export-data.js')}}"></script>		 -->

<script type="text/javascript">
    PNotify.prototype.options.delay -= 50;
    function showNotif(title,message,type){
    	new PNotify({
            title: title,
            text: message,
            addclass: type
        });
    }

</script>
@if(session('pesan'))
<script>
	$(document).ready(function(){
		var type = "alert {{session('status')}} alert-styled-left";
		showNotif("Information","{{session('pesan')}}",type);
	});
</script>
@endif
</body>
</html>
