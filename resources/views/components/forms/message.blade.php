<div>
    <!-- Simplicity is an acquired taste. - Katharine Gerould -->
	@if (session('success'))
		<div @class(['row' => ! $isFullSize])>
			<div @class(['col-md-6' => ! $isFullSize])>
			
				<div class="card card-success">
					  <div class="card-header">
						<h3 class="card-title">Success</h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="remove">
								<i class="fas fa-times"></i>
							</button>
						</div>
						<!-- /.card-tools -->
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<p>{{ session('success') }}</p>
					</div>
					<!-- /.card-body -->
				</div>
			</div>
			
		</div>
	@endif
				  
	@if ($errors->any())
		<div @class(['row' => ! $isFullSize])>
			<div @class(['col-md-6' => ! $isFullSize])>
				<div class="card card-danger">
					<div class="card-header">
						<h3 class="card-title">
							<strong>Whoops!</strong> There were some problems with your input.
						</h3>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="remove">
								<i class="fas fa-times"></i>
							</button>
						</div>
					</div>
					<div class="card-body">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
	@endif
</div>