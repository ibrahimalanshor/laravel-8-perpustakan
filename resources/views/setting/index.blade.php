@extends('__layouts.app')

@section('title', 'Setting')

@section('content')


	<div class="col-md-6 mx-auto">
		<div class="card shadow mb-4">
			<div class="card-header">
				<h6 class="font-weight-bold text-primary m-0">Setting</h6>
			</div>
			<div class="card-body">
				@if(session('success'))
					<div class="alert alert-success alert-dismissible">
						{{ session('success') }}
						<button class="close" data-dismiss="alert">&times;</button>
					</div>
				@endif
				<form action="{{ route('setting.save') }}" method="post">
					@csrf
					@method('put')
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Name" value="{{ site('name') }}" required>

						@error('name')
							<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group">
						<label>Address</label>
						<input type="text" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Address" value="{{ site('address') }}" required>

						@error('address')
							<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group">
						<button class="btn btn-primary" type="submit">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection