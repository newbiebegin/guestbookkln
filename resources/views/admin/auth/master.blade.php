<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>@yield('title')</title>

		<!-- Google Font: Source Sans Pro -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="admin/plugins/fontawesome-free/css/all.min.css">
		<!-- icheck bootstrap -->
		<link rel="stylesheet" href="admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="admin/css/adminlte.min.css">
	</head>
	
	<body class="hold-transition login-page">
		<div class="login-box">
			<div class="login-logo">
				<a href="/"><b>Admin</b></a>
			</div>
			
			<!-- /.login-logo -->
			<div class="card">
				@yield('content')
				
			</div>
		</div>
		<!-- /.login-box -->

		<!-- jQuery -->
		<script src="admin/plugins/jquery/jquery.min.js"></script>
		<!-- Bootstrap 4 -->
		<script src="admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
		<!-- AdminLTE App -->
		<script src="admin/js/adminlte.min.js"></script>
	</body>
</html>
