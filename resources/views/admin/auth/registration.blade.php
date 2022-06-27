@extends('admin.auth.master')

@section('title', 'Register a new membership')
@section('menu.title', 'Register a new membership')

@section('content')
	<div class="card-body register-card-body">
		<p class="login-box-msg">Register a new membership</p>
		
		<x-forms.message :is-full-size='true' /> 
		<br>
		
		<form action="{{ route('register') }}" method="post">
			@csrf
			<div class="input-group mb-3">
				<input type="text" name="name" id="name" class="form-control" placeholder="Name">
				<div class="input-group-append">
					<div class="input-group-text">
						<span class="fas fa-user"></span>
					</div>
				</div>
			</div>

			<div class="input-group mb-3">
				<input type="email" name="email" id="email" class="form-control" placeholder="Email">
				<div class="input-group-append">
					<div class="input-group-text">
						<span class="fas fa-envelope"></span>
					</div>
				</div>
			</div>
			
			<div class="input-group mb-3">
				<input type="password" name="password" id="password" class="form-control" placeholder="Password">
				<div class="input-group-append">
					<div class="input-group-text">
						<span class="fas fa-lock"></span>
					</div>
				</div>
			</div>

			<div class="input-group mb-3">
				<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Retype password">
				<div class="input-group-append">
					<div class="input-group-text">
						<span class="fas fa-lock"></span>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-4">
					<button type="submit" class="btn btn-primary btn-block">Register</button>
				</div>
				<!-- /.col -->
			</div>
		</form>
		<a href="{{route('login')}}" class="text-center">I already have a membership</a>
	</div>
	<!-- /.form-box -->
@endsection('content')