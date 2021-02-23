<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{env('DASHBOARD_TITLE','ConioLabs')}}</title>

	<link rel="shortcut icon" href="{{url('/images/favicon.PNG')}}" />
    <link rel="apple-touch-icon" sizes="32x32" href="{{url('/images/favicon.PNG')}}" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{url('/images/favicon.PNG')}}" />
    <link rel="apple-touch-icon" sizes="120x120" href="{{url('/images/favicon.PNG')}}" />
    <link rel="apple-touch-icon" sizes="152x152" href="{{url('/images/favicon.PNG')}}" />
	
	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="assets/css/colors.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>

	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<script type="text/javascript" src="assets/js/pages/login.js"></script>
	<!-- /theme JS files -->

</head>
<style>
	body{
		/*background-color: #efecec;*/
		background:url("./images/bg.jpg");
         /* Full height */
        height: 100%; 
        /* Center and scale the image nicely */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
	}	
	.flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
        /*background: #24b0bf;*/
        color: #fff;

        background-color: rgba(23, 23, 22, 0.7);
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    .form-horizontal .form-group {
	     margin-left: 0px; 
	     margin-right: 0px; 
	}
</style>
<body class="login-container">

	<div class="flex-center">
		<!-- Page container -->
		<div class="page-container">

			<!-- Page content -->
			<div class="page-content">

				<!-- Main content -->
				<div class="content-wrapper">

					<!-- Content area -->
					<div class="content">
						@yield('content')
						<!-- Footer -->
						<div class="footer text-muted text-center">
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
	</div>
	
</body>
</html>
