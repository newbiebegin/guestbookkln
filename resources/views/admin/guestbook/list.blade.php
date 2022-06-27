
@extends('admin.layouts.master')

@section('title', 'List guestbooks')
@section('menu.title', 'Guestbook')

@section('content')
	
	<div class="row">
		<div class="col-md-12">
			<div class="container-fluid">
			
				<x-forms.message :is-full-size='true'/> 
			
				<div class="card card-default">
					<form action="{{ route('admin.guestbooks.index') }}" method="get" id="formSearch" name="formSearch">
						@csrf
						<div class="card-header">
							<h3 class="card-title">Search</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
								<button type="button" class="btn btn-tool" data-card-widget="remove">
									<i class="fas fa-times"></i>
								</button>
							</div>
						</div>
						<!-- /.card-header -->
					   
						<div class="card-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="name">First Name</label>
										<input type="text" id="first_name" name="first_name" value="{{ old('first_name', $data['first_name'] ?? '') }}" class="form-control @error('first_name') is-invalid @enderror" >
										@error('first_name')
											<span id="first_name-error" class="error invalid-feedback">{{ $message }}</span>
										@enderror('first_name')
									</div>
									<!-- /.form-group -->
								</div>
								<!-- /.col -->
								<div class="col-md-6">
									<div class="form-group">
										<label for="name">Last Name</label>
										<input type="text" id="last_name" name="last_name" value="{{ old('last_name', $data['last_name'] ?? '') }}" class="form-control @error('last_name') is-invalid @enderror" >
										@error('last_name')
											<span id="last_name-error" class="error invalid-feedback">{{ $message }}</span>
										@enderror('last_name')
									</div>
									<!-- /.form-group -->
								</div>
								<!-- /.col -->
								<div class="col-md-6">
									<div class="form-group">
										<label for="name">Organization</label>
										<input type="text" id="organization" name="organization" value="{{ old('organization', $data['organization'] ?? '') }}" class="form-control @error('organization') is-invalid @enderror" >
										@error('organization')
											<span id="organization-error" class="error invalid-feedback">{{ $message }}</span>
										@enderror('organization')
									</div>
									<!-- /.form-group -->
								</div>
								<!-- /.col -->
								<div class="col-md-6">
									<div class="form-group">
										<label for="name">Province</label>
										
										<select id="province_id" name="province_id" class="form-control custom-select  @error('province_id') is-invalid @enderror">
											<option disabled="">Select one</option>
											<option value=""></option>
											@foreach ($ddnProvinces as $valProvince)
												<option value="{{$valProvince->id}}" {{ ($valProvince->id == old('province_id', $data['province_id'] ?? '')) ? "selected" : "" }}>{{$valProvince->name}}</option>
											@endforeach
										</select>
								
										@error('province')
											<span id="province-error" class="error invalid-feedback">{{ $message }}</span>
										@enderror('province')
									</div>
									<!-- /.form-group -->
								</div>
								<!-- /.col -->
								<div class="col-md-6">
									<div class="form-group">
										<label for="name">City</label>
										<select id="city_id" name="city_id" class="form-control custom-select  @error('city_id') is-invalid @enderror">
											<option disabled="">Select one</option>
											<option value=""></option>
											@foreach ($ddnCities as $valCity)
												<option value="{{$valCity->id}}" {{ ($valCity->id == old('city_id', $data['city_id'] ?? '')) ? "selected" : "" }}>{{$valCity->name}}</option>
											@endforeach
										</select>
										@error('city')
											<span id="city-error" class="error invalid-feedback">{{ $message }}</span>
										@enderror('city')
									</div>
									<!-- /.form-group -->
								</div>
								<!-- /.col -->
								<div class="col-md-6">
									<div class="form-group">
										<label for="is_active">Active Status</label>
										<select id="is_active" name="is_active" class="form-control custom-select  @error('is_active') is-invalid @enderror">
											<option disabled="">Select one</option>
											@foreach ($ddnActiveStatus as $keyActiveStatus => $valActiveStatus)
												<option value="{{$keyActiveStatus}}" {{ ($keyActiveStatus == old('is_active', $data['is_active'] ?? '')) ? "selected" : "" }}>{{$valActiveStatus}}</option>
											@endforeach
										</select>
										@error('is_active')
											<span id="is_active-error" class="error invalid-feedback">{{ $message }}</span>
										@enderror('is_active')
									</div>
								
								</div>
								<!-- /.col -->							
							</div>
							<!-- /.row -->
						</div>
						<!-- /.card-body -->
						
						<div class="card-footer  text-center">
							
							<button type="reset" class="btn btn-secondary" id="btnReset">
								Cancel
							</button>
							
							<button type="submit" class="btn btn-primary">
								Search
							</button>
						</div>
					</form>
				</div>

				<!-- Default box -->
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">List</h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
								<i class="fas fa-minus"></i>
							</button>
							<button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
								<i class="fas fa-times"></i>
							</button>
						</div>
					</div>
					<div class="card-body p-0">
						<table class="table table-striped projects">
							<thead>
								<tr>
									<th style="width: 1%">
										#
									</th>
									<th>
										First Name
									</th>
									<th>
										Last Name
									</th>
									<th>
										Organization
									</th>
									<th>
										Address
									</th>
									<th>
										Province
									</th>
									<th>
										City
									</th>
									<th style="width: 10%">
										Phone
									</th>
									<th>
										Message
									</th>
									<th style="width: 8%" class="text-center">
										Status
									</th>
									<th style="width: 10%">
									</th>
								</tr>
							</thead>
							<tbody>
							
							@foreach ($guestbooks as $guestbook)
								@php
								
									if($guestbook->is_active == config('constants.ACTIVE_STATUS_ACTIVE'))
										$spanClass = 'success';
									elseif($guestbook->is_active == config('constants.ACTIVE_STATUS_INACTIVE'))
										$spanClass = 'secondary';
									else
										$spanClass = 'warning';
									
									$guestbookId = $guestbook->id;
								@endphp
									
								<tr>
									<td>
										{{ ($guestbooks->currentPage() - 1)  * $guestbooks->links()->paginator->perPage() + $loop->iteration }}
									</td>
									<td>
										<a>
											{{$guestbook->first_name}}
										</a>
										<br/>
										<small>
											Last Updated {{$guestbook->updated_at}}
										</small>
									</td>
									<td>
										<a>
											{{$guestbook->last_name}}
										</a>
									</td>
									<td>
										{{$guestbook->organization}}
									</td>
									<td>
										{{$guestbook->address}}
									</td>
									<td>
										{{$guestbook->province->name}}
									</td>
									<td>
										{{$guestbook->city->name}}
									</td>
									<td>
										{{$guestbook->phone}}
									</td>
									<td>
										{{$guestbook->message}}
									</td>
									<td class="project-state">
									
										<span class="badge badge-{{$spanClass}}">{{ DropdownHelper::numToActiveStatusName($guestbook->is_active)}}</span>
									</td>
							
									<td class="project-actions text-right">
										<a class="btn btn-info btn-sm" href="{{route('admin.guestbooks.edit', ['guestbook' => $guestbookId])}}">
											<i class="fas fa-pencil-alt">
											</i>
											Edit
										</a>
										<a class="btn btn-danger btn-sm" href="{{route('admin.guestbooks.destroy', ['guestbook' => $guestbookId])}}" data-toggle="modal" data-target="#modal-confirm" data-type="DELETE" data-id="{{$guestbookId}}" id="modalConfirmDelete">
											<i class="fas fa-trash">
											</i>
											Delete
										</a>
									</td>
								</tr>
							@endforeach
							 
							</tbody>
						</table>
						
					</div>
					<!-- /.card-body -->
					<div class="card-footer clearfix">
						{{$guestbooks->onEachSide(1)->appends($data)->links('vendor.pagination.custom')}}
					</div><!---->
				</div>
				<!-- /.card -->
				
				<div class="modal fade" id="modal-confirm">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							
							<form action="" method="post" id="formModalConfirm" name="formModalConfirm">
								@csrf
								<!-- @method('DELETE')-->
								<div id="formMethod">
								</div>
							
								<div class="modal-header bg-warning">
									<h4 class="modal-title">Info</h4>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<p>Are you sure ?&hellip;</p>
									<input type="hidden" id="txtKey" name="txtKey" readonly="true">
								</div>
								<div class="modal-footer justify-content-between">
									<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
									<button type="button" class="btn btn-primary" id="modalConfirmDeleteBtnYes">Yes</button>
								</div>
							</form>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->
			</div>
		</div>
	</div>
@endsection('content')


@section('javaScripts')
	<script src="{{asset('admin/js/pages/guestbook/form.js')}}"></script>
@stop	