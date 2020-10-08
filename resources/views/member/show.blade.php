@extends('__layouts.app')

@section('title', $member->name)

@section('content')

	<div class="row">

		<div class="col-md-4">
			<div class="card shadow mb-4">
				<div class="card-body">
					<img src="{{ img($member->photo) }}" class="img-fluid">
				</div>
			</div>
		</div>

		<div class="col-md-8">
			<div class="card shadow mb-4">
				<div class="card-header">
					<h6 class="font-weight-bold text-primary m-0">Data Member</h6>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered" width="100%">
							<tbody>
								<tr>
									<th>Name</th>
									<td>{{ $member->name }}</td>
								</tr>
								<tr>
									<th>Gender</th>
									<td>{{ $member->gender }}</td>
								</tr>
								<tr>
									<th>Birthday</th>
									<td>{{ localDate($member->birthday) }}</td>
								</tr>
								<tr>
									<th>Phone</th>
									<td>{{ $member->phone }}</td>
								</tr>
								<tr>
									<th>Address</th>
									<td>{{ $member->address }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="card-footer">
					<a href="{{ url()->previous() }}" class="btn btn-danger">Back</a>
				</div>
			</div>
		</div>
	
	</div>


@endsection