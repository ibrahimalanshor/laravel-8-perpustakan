@extends('__layouts.app')

@section('title', 'Category')

@section('content')

	<div class="row">
		<div class="col-md-4">
			<div class="card shadow mb-4">
			<form action="" id="create">
				<div class="card-header">
					<h6 class="card-title my-0 font-weight-bold text-primary">Add Category</h6>
				</div>
				<div class="card-body">
					@csrf
					<div class="form-group">
						<label>Name</label>
						<input type="text" name="name" class="form-control" placeholder="Name" required></input>

						<span class="invalid-feedback"></span>
					</div>
				</div>
				<div class="card-footer">
					<button class="btn btn-primary" type="primary">Add</button>
				</div>
			</div>
			</form>
		</div>
		<div class="col-md-8">
			<div class="card shadow">
				<div class="card-header">
					<h6 class="card-title my-0 font-weight-bold text-primary">Data Categories</h6>
				</div>
				<div class="card-body">
					<div id="alert"></div>
					<div class="table-responsive">
						<table class="table table-bordered table-striped" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Name</th>
									<th>Action</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal" id="edit">
	<div class="modal-dialog">
	<div class="modal-content">
	<form>
		<div class="modal-header">
			<h5 class="modal-title">Edit Data</h5>
			<button class="close" data-dismiss="modal">&times;</button>
		</div>
		<div class="modal-body">
			@csrf
			@method('put')
			<div class="form-group">
				<label>Name</label>
				<input type="text" class="form-control" name="name" placeholder="Name" autofocus>

				<span class="invalid-feedback"></span>
			</div>
		</div>
		<div class="modal-footer">
			<button class="btn btn-primary" type="submit">Update</button>
			<button class="btn btn-danger" data-dismiss="modal">Cancel</button>
		</div>
	</form>
	</div>
	</div>
	</div>

@endsection

@push('styles')

	<link rel="stylesheet" href="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.css') }}">

@endpush

@push('scripts')

	<script>
		let ajaxUrl = "{{ route('category.index') }}"
		let createUrl = "{{ route('category.store') }}"
		let updateUrl = "{{ route('category.update', ':id') }}"
		let deleteUrl = "{{ route('category.destroy', ':id') }}"
		let csrf = "{{ csrf_token() }}"
	</script>

	<script src="{{ asset('sbadmin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

	<script src="{{ asset('js/category.js') }}"></script>

@endpush