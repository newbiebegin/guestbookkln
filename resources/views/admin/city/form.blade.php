@extends('admin.layouts.master')
@section('title', $template['title'])
@section('menu.title', $template['menuTitle'])
@section('content')


	<div class="container-fluid">

		<x-forms.message /> 
		
		<form action="{{ $template['action'] }}" method="POST" id="formEdit" name="formEdit" data-key="{{$city->id ?? '0'}}">
			@csrf
			
			@if(isset($city))
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
								<label for="code">Code <code>*</code></label>
								<input type="text" id="code" name="code" value="{{ old('code', $city->code ?? '') }}" class="form-control @error('code') is-invalid @enderror">
								@error('code')
									<span id="code-error" class="error invalid-feedback">{{ $message }}</span>
								@enderror('code')
							</div>
							<div class="form-group">
								<label for="name">Name <code>*</code></label>
								<input type="text" id="name" name="name" value="{{ old('name', $city->name ?? '') }}" class="form-control @error('name') is-invalid @enderror" >
								@error('name')
									<span id="name-error" class="error invalid-feedback">{{ $message }}</span>
								@enderror('name')
							</div>							
							<div class="form-group">
								<label for="is_active">Active Status <code>*</code></label>
								<select id="is_active" name="is_active" class="form-control custom-select  @error('is_active') is-invalid @enderror">
									<option disabled="">Select one</option>
									@foreach ($ddnActiveStatus as $keyActiveStatus => $valActiveStatus)
										<option value="{{$keyActiveStatus}}" {{ ($keyActiveStatus == old('is_active', $city->active_status ?? '')) ? "selected" : "" }}>{{$valActiveStatus}}</option>
									@endforeach
								</select>
								@error('is_active')
									<span id="is_active-error" class="error invalid-feedback">{{ $message }}</span>
								@enderror('is_active')
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
	<script src="{{asset('admin/js/pages/city/form.js')}}"></script>
@stop	