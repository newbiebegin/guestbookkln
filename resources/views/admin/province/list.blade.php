
@extends('admin.layouts.master')

@section('title', 'List provinces')
@section('menu.title', 'Province')

@section('content')
	
	<div class="row">
		<div class="col-md-12">
			<div class="container-fluid">
			
				<x-forms.message :is-full-size='true'/> 
			
				<div class="card card-default">
					<form action="{{ route('admin.provinces.index') }}" method="get" id="formSearch" name="formSearch">
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
										<label for="name">Name</label>
										<input type="text" id="name" name="name" value="{{ old('name', $data['name'] ?? '') }}" class="form-control @error('name') is-invalid @enderror" >
										@error('name')
											<span id="name-error" class="error invalid-feedback">{{ $message }}</span>
										@enderror('name')
									</div>
									<!-- /.form-group -->
								</div>
								<!-- /.col -->
								<div class="col-md-6">
									<div class="form-group">
										<label for="code">Code</label>
										<input type="text" id="code" name="code" value="{{ old('code', $data['code'] ?? '') }}" class="form-control @error('code') is-invalid @enderror">
										@error('code')
											<span id="code-error" class="error invalid-feedback">{{ $message }}</span>
										@enderror('code')
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
							<button type="button" class="btn btn-secondary " id="btnImport">
								Import
							</button>
							
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
										Name
									</th>
									<th style="width: 10%">
										Code
									</th>
									<th style="width: 8%" class="text-center">
										Status
									</th>
									<th style="width: 20%">
									</th>
								</tr>
							</thead>
							<tbody>
							
							@foreach ($provinces as $province)
								@php
								
									if($province->is_active == config('constants.ACTIVE_STATUS_ACTIVE'))
										$spanClass = 'success';
									elseif($province->is_active == config('constants.ACTIVE_STATUS_INACTIVE'))
										$spanClass = 'secondary';
									else
										$spanClass = 'warning';
									
									$provinceId = $province->id;
								@endphp
									
								<tr>
									<td>
										{{ ($provinces->currentPage() - 1)  * $provinces->links()->paginator->perPage() + $loop->iteration }}
									</td>
									<td>
										<a>
											{{$province->name}}
										</a>
										<br/>
										<small>
											Last Updated {{$province->updated_at}}
										</small>
									</td>
									<td>
										<a>
											{{$province->code}}
										</a>
									</td>
									<td class="project-state">
									
										<span class="badge badge-{{$spanClass}}">{{ DropdownHelper::numToActiveStatusName($province->is_active)}}</span>
									</td>
							
									<td class="project-actions text-right">
										<a class="btn btn-info btn-sm" href="{{route('admin.provinces.edit', ['province' => $provinceId])}}">
											<i class="fas fa-pencil-alt">
											</i>
											Edit
										</a>
										<a class="btn btn-danger btn-sm" href="{{route('admin.provinces.destroy', ['province' => $provinceId])}}" data-toggle="modal" data-target="#modal-confirm" data-type="DELETE" data-id="{{$provinceId}}" id="modalConfirmDelete">
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
						{{$provinces->onEachSide(1)->appends($data)->links('vendor.pagination.custom')}}
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
	<script src="{{asset('admin/js/pages/province/form.js')}}"></script>
@stop	