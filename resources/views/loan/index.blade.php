@extends('__layouts.app')

@section('title', 'Loan')

@section('content')

	<div class="card shadow mb-4">
		<div class="card-header d-flex align-items-center justify-content-between">
			<h6 class="font-weight-bold text-primary m-0">Data Loan</h6>
			<div>
				<button class="btn btn-sm btn-success" data-toggle="collapse" data-target="#filter">Filter</button>
				<a href="{{ route('loan.create') }}" class="btn btn-primary btn-sm">Make Loan</a>
			</div>
		</div>
		<div class="card-body border-bottom collapse" id="filter">
			<form class="form-row">
				<div class="col-sm-4">
					<div class="form-group">
						<label>Member</label>
						<input type="text" class="form-control" data-filter="member" placeholder="Member">
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<label>Return</label>
						<input type="date" class="form-control" data-filter="return" placeholder="Return">
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<label>Status</label>
						<select data-filter="status" class="form-control custom-select">
							<option value="1">Active</option>
							<option value="0">Returned</option>
						</select>
					</div>
				</div>
			</form>
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
							<th>Book</th>
							<th>Member</th>
							<th>Return</th>
							<th>Late</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>

	@include('loan.return')
	@include('loan.extend')

@endsection

@push('styles')

	<link rel="stylesheet" href="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.css') }}">

@endpush

@push('scripts')

	<script>
		let ajaxUrl = "{{ route('loan.index') }}"
		let returnUrl = "{{ route('loan.return', ':id') }}";
		let extendUrl = "{{ route('loan.extend', ':id') }}";
		let deleteUrl = "{{ route('loan.destroy', ':id') }}"
		let csrf = "{{ csrf_token() }}"
	</script>

	<script src="{{ asset('sbadmin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

	<script src="{{ asset('js/loan.js') }}"></script>

@endpush