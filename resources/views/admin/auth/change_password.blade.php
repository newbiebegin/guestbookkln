@extends('admin.auth.master')

@section('title', 'Change Password')
@section('menu.title', 'Change Password')

@section('content')
	<div class="card-body login-card-body">
		<p class="login-box-msg">Change Password</p>
		
		<x-forms.message :is-full-size='true' /> 
		<br>

		<form action="{{route('change.password')}}" method="post">
			@csrf
			
			<div class="input-group mb-3">
				<input type="password" name="current_password" id="current_password" class="form-control" placeholder="Current Password" >
				<div class="input-group-append">
					<div class="input-group-text">
						<span class="fas fa-lock"></span>
					</div>
				</div>
			</div>

			<div class="input-group mb-3">
				<input type="password" name="new_password" id="new_password" class="form-control" placeholder="New Password" >
				<div class="input-group-append">
					<div class="input-group-text">
						<span class="fas fa-lock"></span>
					</div>
				</div>
			</div>
			
			<div class="input-group mb-3">
				<input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" placeholder="Retype new password">
				<div class="input-group-append">
					<div class="input-group-text">
						<span class="fas fa-lock"></span>
					</div>
				</div>
			</div>
			
			<div class="row">
				
				<!-- /.col -->
				<div class="col-4">
					<button type="button" onClick="window.history.back()" class="btn btn-secondary btn-block">Back</button>
				</div>
				<!-- /.col -->
				<!-- /.col -->
				<div class="col-4">
					<button type="submit" class="btn btn-primary btn-block">Save</button>
				</div>
				<!-- /.col -->
			</div>
		</form>
	</div>
	<!-- /.login-card-body -->
		
@endsection('content')
