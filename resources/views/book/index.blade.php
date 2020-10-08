@extends('__layouts.app')

@section('title', 'Book')

@section('content')

	<div class="card shadow mb-4">
		<div class="card-header d-flex align-items-center justify-content-between">
			<h6 class="font-weight-bold text-primary m-0">Data Book</h6>
			<div>
				<a href="{{ route('book.create') }}" class="btn btn-primary btn-sm">New Book</a>
			</div>
		</div>
		<div class="card-body">
			<div id="alert">
				@if(session('success'))
					<div class="alert alert-success alert-dismissible">
						{{ session('success') }}
						<button class="close" data-dismiss="alert">&times;</button>
					</div>
				@endif
			</div>
			<div class="table-responsive">
				<table class="table table-bordered table-striped" width="100%">
					<thead>
						<tr>
							<th>No</th>
							<th>Code</th>
							<th>Name</th>
							<th>Writer</th>
							<th>Year</th>
							<th>Stock</th>
							<th>Action</th>
						</tr>
					</thead>
				</table>
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
				<label>Code</label>
				<input type="text" class="form-control" name="code" placeholder="Code" autofocus>

				<span class="invalid-feedback"></span>
			</div>
			<div class="form-group">
				<label>Name</label>
				<input type="text" class="form-control" name="name" placeholder="Name" required>

				<span class="invalid-feedback"></span>
			</div>
			<div class="form-group">
				<label>Category</label>
				<select name="category_id" class="form-control custom-select" required></select>

				@error('category_id')
					<span class="invalid-feedback">{{ $message }}</span>
				@enderror
			</div>
			<div class="form-group">
				<label>Writer</label>
				<input type="text" class="form-control" name="writer" placeholder="Writer" required>
				
				<span class="invalid-feedback"></span>
			</div>
			<div class="form-group">
				<label>Year</label>
				<input type="number" maxlength="4" class="form-control" name="year" placeholder="Year" required>
				
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
	<link rel="stylesheet" href="{{ asset('sbadmin/vendor/select2/css/select2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('sbadmin/vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endpush

@push('scripts')

	<script>
		let ajaxUrl = "{{ route('book.index') }}"
		let updateUrl = "{{ route('book.update', ':id') }}"
		let deleteUrl = "{{ route('book.destroy', ':id') }}"
		let getCategoryUrl = "{{ route('category.get') }}"
		let csrf = "{{ csrf_token() }}"
	</script>

	<script src="{{ asset('sbadmin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('sbadmin/vendor/select2/js/select2.min.js') }}"></script>

	<script src="{{ asset('js/book.js') }}"></script>

@endpush