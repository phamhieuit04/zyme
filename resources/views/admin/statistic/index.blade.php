@extends('index')

@section('content')
	<div class="col-md-12">
		<h1>ユーザ追加</h1>
		<div class="row">
			<div class="col-md-9"></div>
			<div class="col-md-3">
				<form action="{{ url('/statistic') }}" method="GET">
					<div class="row">
						@csrf
						<div class="col-md-8">
							<input type="date" name="date" class="form-control">
						</div>
						<div class="col-md-4">
							<button style="height: 40px;" type="submit" class="btn btn-primary">Submit</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-12" id="btn-action-import-export">
		<a href="{{ url('/statistic/export') }}" class="btn btn-primary">Export</a>
		<a href="{{ url('/statistic/import') }}" class="btn btn-primary">Import</a>
	</div>

	<table class="table table-hover table-bordered">
		<thead>
			<th>#</th>
			<th>Name</th>
			<th>Email</th>
			<th>Total files</th>
			<th>Status</th>
			<th>Salary</th>
			<th>Paid</th>
		</thead>
		<tbody>
			@if (count($salaries) > 0)
				@foreach ($salaries as $salary)
					<tr>
						<td>{{ $salary->id }}</td>
						<td>{{ $salary->user->name }}</td>
						<td>{{ $salary->user->email }}</td>
						<td>{{ count($salary->user->files) }}</td>
						<td>{{ $salary->txt_status }}</td>
						<td>{{ $salary->salary }}</td>
						<td>
							@if ($salary->status == 0)
								<a href="{{ url('/statistic/paid-salary/' . $salary->id) }}" class="btn btn-primary">Paid</a>
							@else
								<a class="btn btn-success disabled">Paided</a>
							@endif
						</td>
					</tr>
				@endforeach
			@endif
		</tbody>
	</table>
@endsection