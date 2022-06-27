<!DOCTYPE html>
<html lang="en" height="auto">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="_token" content="{{csrf_token()}}" />
		<title>KLN | @yield('title')</title>

		<!-- Google Font: Source Sans Pro -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="{{asset('admin/plugins/fontawesome-free/css/all.min.css')}}">
		<!-- Ionicons -->
		<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
		<!-- Tempusdominus Bootstrap 4 -->
		<link rel="stylesheet" href="{{asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
		<!-- iCheck -->
		<link rel="stylesheet" href="{{asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
		<!-- JQVMap -->
		<!--
		<link rel="stylesheet" href="{{asset('admin/plugins/jqvmap/jqvmap.min.css')}}">
		-->
		<!-- Theme style -->
		<link rel="stylesheet" href="{{asset('admin/css/adminlte.min.css')}}">
		<!-- overlayScrollbars -->
		<link rel="stylesheet" href="{{asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
		<!-- Daterange picker -->
		<link rel="stylesheet" href="{{asset('admin/plugins/daterangepicker/daterangepicker.css')}}">
		
		<!-- summernote -->
		<!--
		<link rel="stylesheet" href="{{asset('admin/plugins/summernote/summernote-bs4.min.css')}}">
		-->
		<!-- duallistbox -->
		<link rel="stylesheet" href="{{asset('admin/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">
	</head>
	<body class="hold-transition sidebar-mini">
		<div class="wrapper">

			<!-- Preloader -->
		<!--
			<div class="preloader flex-column justify-content-center align-items-center">
				<img class="animation__shake" src="{{asset('admin/img/salurankasih.jpeg')}}" alt="Saluran Kasih" height="60" width="60">
			</div>
		-->
			<!-- Navbar -->
			@include("admin.partials.navBar")
			<!-- /.navbar -->

			<!-- Main Sidebar Container -->
			@include("admin.partials.sidebar")

			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				@include("admin.partials.headerContent")
				<!-- /.content-header -->
				
				<!-- Main content -->
				<section class="content">
				
					@yield('content')
				</section>
				<!-- /.content -->
			</div>
			<!-- /.content-wrapper -->

			@include("admin.partials.footer")

			<!-- Control Sidebar -->
			<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
			</aside>
			<!-- /.control-sidebar -->
		</div>
		<!-- ./wrapper -->

		<!-- jQuery -->
		<script src="{{asset('admin/plugins/jquery/jquery.min.js')}}"></script>
		<!-- jQuery UI 1.11.4 -->
		<script src="{{asset('admin/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
		<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
		<script>
			$.widget.bridge('uibutton', $.ui.button)
		</script>
		<!-- Bootstrap 4 -->
		<script src="{{asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
		<!-- ChartJS -->
		<!--
		<script src="{{asset('admin/plugins/chart.js/Chart.min.js')}}"></script>
		-->
		<!-- Sparkline -->
		<!--
		<script src="{{asset('admin/plugins/sparklines/sparkline.js')}}"></script>
		-->
		<!-- JQVMap -->
		<!--
		<script src="{{asset('admin/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
		<script src="{{asset('admin/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
		-->
		<!-- jQuery Knob Chart -->
		<!--
		<script src="{{asset('admin/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
		-->
		<!-- daterangepicker -->
		<script src="{{asset('admin/plugins/moment/moment.min.js')}}"></script>
		<script src="{{asset('admin/plugins/daterangepicker/daterangepicker.js')}}"></script>
		<!-- Tempusdominus Bootstrap 4 -->
		<script src="{{asset('admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
		<!-- Summernote -->
		<!--
		<script src="{{asset('admin/plugins/summernote/summernote-bs4.min.js')}}"></script>
		-->
		<!-- overlayScrollbars -->
		<script src="{{asset('admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
		<!-- AdminLTE App -->
		<script src="{{asset('admin/js/adminlte.js')}}"></script>
		<!-- AdminLTE for demo purposes -->
		<!-- <script src="dist/js/demo.js"></script> -->
		<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	<!--
		<script src="{{asset('admin/js/pages/dashboard.js')}}"></script>
	-->
	
	
		@yield('javaScripts')
	</body>
</html>
