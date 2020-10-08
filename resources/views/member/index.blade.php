@extends('__layouts.app')

@section('title', 'Member')

@section('content')

	<div class="card shadow mb-4">
		<div class="card-header d-flex align-items-center justify-content-between">
			<h6 class="font-weight-bold text-primary m-0">Data Member</h6>
			<div>
				<a href="{{ route('member.create') }}" class="btn btn-primary btn-sm">New Member</a>
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
							<th>Name</th>
							<th>Gender</th>
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
			<div class="form-row">
				<div class="col-sm-6">
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="form-control" name="name" placeholder="Name" autofocus required>

						<span class="invalid-feedback"></span>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Phone</label>
						<input type="number" class="form-control" name="phone" placeholder="Phone" required>

						<span class="invalid-feedback"></span>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Gender</label>
						<select name="gender" class="form-control custom-select" required>
							<option value="male">Male</option>
							<option value="female">Female</option>
						</select>

						<span class="invalid-feedback"></span>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Birthday</label>
						<input type="date" class="form-control" name="birthday" placeholder="birthday" required>

						<span class="invalid-feedback"></span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label>Address</label>
				<textarea class="form-control" name="address" placeholder="Address" required></textarea>

				<span class="invalid-feedback"></span>
			</div>
			<div class="form-group">
				<label>Photo</label>
				<div class="custom-file">
					<label class="custom-file-label" id="photo">Upload</label>
					<input type="file" class="custom-file-input" name="file" placeholder="Photo">
					
					<span class="invalid-feedback"></span>
				</div>

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

@endpush

@push('scripts')

	<script>
		let ajaxUrl = "{{ route('member.index') }}"
		let updateUrl = "{{ route('member.update', ':id') }}"
		let deleteUrl = "{{ route('member.destroy', ':id') }}"
		let csrf = "{{ csrf_token() }}"
	</script>

	<script src="{{ asset('sbadmin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('sbadmin/vendor/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

	<script src="{{ asset('js/member.js') }}"></script>

@endpush