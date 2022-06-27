@extends('admin.layouts.master')
@section('title', $template['title'])
@section('menu.title', $template['menuTitle'])
@section('content')


	<div class="container-fluid">

		<x-forms.message /> 
		
		<form action="{{ $template['action'] }}" method="POST" id="formEdit" name="formEdit" data-key="{{$guestbook->id ?? '0'}}">
			@csrf
			
			@if(isset($guestbook))
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
								<label for="first_name">First Name <code>*</code></label>
								<input type="text" id="first_name" name="first_name" value="{{ old('first_name', $guestbook->first_name ?? '') }}" class="form-control @error('first_name') is-invalid @enderror">
								@error('first_name')
									<span id="first_name-error" class="error invalid-feedback">{{ $message }}</span>
								@enderror('first_name')
							</div>
							<div class="form-group">
								<label for="last_name">Last Name</label>
								<input type="text" id="last_name" name="last_name" value="{{ old('last_name', $guestbook->last_name ?? '') }}" class="form-control @error('last_name') is-invalid @enderror" >
								@error('last_name')
									<span id="last_name-error" class="error invalid-feedback">{{ $message }}</span>
								@enderror('last_name')
							</div>		
							<div class="form-group">
								<label for="last_name">Organization</label>
								<input type="text" id="organization" name="organization" value="{{ old('organization', $guestbook->organization ?? '') }}" class="form-control @error('organization') is-invalid @enderror" >
								@error('organization')
									<span id="organization-error" class="error invalid-feedback">{{ $message }}</span>
								@enderror('organization')
							</div>			
							<div class="form-group">
								<label for="last_name">Address <code>*</code></label>
								<textarea id="address" name="address" class="form-control @error('address') is-invalid @enderror">{{ old('address', $guestbook->address ?? '') }}</textarea>
								@error('address')
									<span id="address-error" class="error invalid-feedback">{{ $message }}</span>
								@enderror('address')
							</div>				
							<div class="form-group">
								<label for="province">Province <code>*</code></label>
								<select id="province_id" name="province_id" class="form-control custom-select  @error('province_id') is-invalid @enderror">
									<option disabled="">Select one</option>
									<option value=""></option>
									@foreach ($ddnProvinces as $valProvince)
										<option value="{{$valProvince->id}}" {{ ($valProvince->id == old('province_id', $guestbook->province_id ?? '')) ? "selected" : "" }}>{{$valProvince->name}}</option>
									@endforeach
								</select>
								@error('province_id')
									<span id="province_id-error" class="error invalid-feedback">{{ $message }}</span>
								@enderror('province_id')
							</div>						
							<div class="form-group">
								<label for="city">City <code>*</code></label>
								<select id="city_id" name="city_id" class="form-control custom-select  @error('city_id') is-invalid @enderror">
									<option disabled="">Select one</option>
									<option value=""></option>
									@foreach ($ddnCities as $valCity)
										<option value="{{$valCity->id}}" {{ ($valCity->id == old('city_id', $guestbook->city_id ?? '')) ? "selected" : "" }}>{{$valCity->name}}</option>
									@endforeach
								</select>
								@error('city_id')
									<span id="city_id-error" class="error invalid-feedback">{{ $message }}</span>
								@enderror('city_id')
							</div>				
							<div class="form-group">
								<label for="phone">Phone <code>*</code></label>
								<input type="text" id="phone" name="phone" value="{{ old('phone', $guestbook->phone ?? '') }}" class="form-control @error('phone') is-invalid @enderror" >
								@error('phone')
									<span id="phone-error" class="error invalid-feedback">{{ $message }}</span>
								@enderror('phone')
							</div>				
							<div class="form-group">
								<label for="message">Message <code>*</code></label>
								<textarea id="message" name="message" class="form-control @error('message') is-invalid @enderror" >{{ old('message', $guestbook->message ?? '') }}</textarea>
								@error('message')
									<span id="message-error" class="error invalid-feedback">{{ $message }}</span>
								@enderror('message')
							</div>							
							<div class="form-group">
								<label for="is_active">Active Status <code>*</code></label>
								<select id="is_active" name="is_active" class="form-control custom-select  @error('is_active') is-invalid @enderror">
									<option disabled="">Select one</option>
									@foreach ($ddnActiveStatus as $keyActiveStatus => $valActiveStatus)
										<option value="{{$keyActiveStatus}}" {{ ($keyActiveStatus == old('is_active', $guestbook->active_status ?? '')) ? "selected" : "" }}>{{$valActiveStatus}}</option>
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
	<script src="{{asset('admin/js/pages/guestbook/form.js')}}"></script>
@stop	