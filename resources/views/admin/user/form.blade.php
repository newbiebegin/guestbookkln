@extends('admin.layouts.master')
@section('title', $template['title'])
@section('menu.title', $template['menuTitle'])
@section('content')


	<div class="container-fluid">

		<x-forms.message /> 
		
		<form action="{{ $template['action'] }}" method="POST" id="formEdit" name="formEdit" data-key="{{$user->id ?? '0'}}">
			@csrf
			
			@if(isset($user))
				@method('PUT')
			@endif

			<div class="row">
				<div class="col-md-6">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">General</h3>

							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
								<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						
						<div class="card-body">
							
							<div class="form-group">
								<label for="name">Name <code>*</code></label>
								<input type="text" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" class="form-control @error('name') is-invalid @enderror" disabled>
								@error('name')
									<span id="name-error" class="error invalid-feedback">{{ $message }}</span>
								@enderror('name')
							</div>			
							<div class="form-group">
								<label for="email">Email <code>*</code></label>
								<input type="text" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="form-control @error('email') is-invalid @enderror" disabled>
								@error('email')
									<span id="email-error" class="error invalid-feedback">{{ $message }}</span>
								@enderror('email')
							</div>			
							<div class="form-group">
								<label for="password">Password <code>*</code></label>
								<input type="password" id="password" name="password" value="{{ old('password', '') }}" class="form-control @error('password') is-invalid @enderror">
								@error('password')
									<span id="password-error" class="error invalid-feedback">{{ $message }}</span>
								@enderror('password')
							</div>			
							<div class="form-group">
								<label for="password_confirmation">Password Confirmation <code>*</code></label>
								<input type="password" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation', '') }}" class="form-control @error('password_confirmation') is-invalid @enderror">
								@error('password_confirmation')
									<span id="password_confirmation-error" class="error invalid-feedback">{{ $message }}</span>
								@enderror('password_confirmation')
							</div>			
							<p><code>*</code>) Required</p>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>

			
			</div>

			<div class="row">
				<div class="col-12">
					<input type="reset" value="Clear" class="btn btn-secondary">
					<input type="submit" value="{{$template['action_label']}}" class="btn btn-success">
				</div>
			</div>
		</form>	
	</div>
@endsection('content')

@section('javaScripts')
	<script src="{{asset('admin/js/pages/user/form.js')}}"></script>
@stop	