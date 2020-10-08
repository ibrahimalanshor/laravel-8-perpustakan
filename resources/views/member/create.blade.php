@extends('__layouts.app')

@section('title', 'Add Member')

@section('content')


	<div class="col-md-6 mx-auto">
		<div class="card shadow mb-4">
			<div class="card-header">
				<h6 class="font-weight-bold text-primary m-0">Add Member</h6>
			</div>
			<div class="card-body">
				<form action="{{ route('member.store') }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="form-row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Name</label>
								<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Name" value="{{ old('name') }}" required>

								@error('name')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Phone</label>
								<input type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" placeholder="Phone" value="{{ old('phone') }}" required>

								@error('phone')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Gender</label>
								<select name="gender" class="form-control custom-select @error('gender') is-invalid @enderror" required>
									<option value="male">Male</option>
									<option value="female">Female</option>
								</select>

								@error('gender')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Birthday</label>
								<input type="date" class="form-control @error('birthday') is-invalid @enderror" name="birthday" placeholder="birthday" value="{{ old('birthday') }}" required>

								@error('birthday')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Address</label>
						<textarea class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Address" required>{{ old('address') }}</textarea>

						@error('address')
							<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group">
						<label>Photo</label>
						<div class="custom-file">
							<label class="custom-file-label">Upload</label>
							<input type="file" class="custom-file-input @error('file') is-invalid @enderror" name="file" placeholder="Photo" value="{{ old('file') }}" required>
							
							@error('file')
								<span class="invalid-feedback">{{ $message }}</span>
							@enderror
						</div>

					</div>
					<div class="form-group">
						<button class="btn btn-primary" type="submit">Add</button>
						<a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection

@push('scripts')

	<script src="{{ asset('sbadmin/vendor/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

	<script>
		bsCustomFileInput.init()
	</script>

@endpush