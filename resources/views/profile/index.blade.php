@extends('__layouts.app')

@section('title', 'Profile')

@section('content')


	<div class="col-md-6 mx-auto">
		<div class="card shadow mb-4">
			<div class="card-header">
				<h6 class="font-weight-bold text-primary m-0">Profile</h6>
			</div>
			<div class="card-body">
				@if(session('success'))
					<div class="alert alert-success alert-dismissible">
						{{ session('success') }}
						<button class="close" data-dismiss="alert">&times;</button>
					</div>
				@endif
				<form action="{{ route('profile.save') }}" method="post">
					@csrf
					@method('put')
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Name" value="{{ Auth::user()->name }}" required>

						@error('name')
							<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ Auth::user()->email }}" required>

						@error('email')
							<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password">

						@error('password')
							<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group">
						<label>Confirm Password</label>
						<input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
					</div>
					<div class="form-group">
						<button class="btn btn-primary" type="submit">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection