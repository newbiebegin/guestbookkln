@extends('admin.auth.master')

@section('title', 'Login')
@section('menu.title', 'Login')

@section('content')
	<div class="card-body login-card-body">
		<p class="login-box-msg">Sign in to start your session</p>
		
		<x-forms.message :is-full-size='true' /> 
		<br>

		<form action="{{route('login.post')}}" method="post">
			@csrf
			<div class="input-group mb-3">
				<input type="email" dusk="login-email" name="email" id="email" class="form-control" placeholder="Email" >
				<div class="input-group-append">
					<div class="input-group-text">
						<span class="fas fa-envelope"></span>
					</div>
				</div>
			</div>

			<div class="input-group mb-3">
				<input type="password" dusk="login-password" name="password" id="password" class="form-control" placeholder="Password" >
				<div class="input-group-append">
					<div class="input-group-text">
						<span class="fas fa-lock"></span>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-8">
					<div class="icheck-primary">
						<input type="checkbox" id="remember">
						<label for="remember">
							Remember Me
						</label>
					</div>
				</div>
	  
				<!-- /.col -->
				<div class="col-4">
					<button type="submit" class="btn btn-primary btn-block">Sign In</button>
				</div>
				<!-- /.col -->
			</div>
		</form>

		<p class="mb-0">
			<a href="{{route('registration')}}" class="text-center">Register a new membership</a>
		</p>
	</div>
	<!-- /.login-card-body -->
		
@endsection('content')