<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
	<link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
	<title>
		Soft UI Dashboard 3 by Creative Tim
	</title>
	<!--     Fonts and icons     -->
	<link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet">
	<!-- Nucleo Icons -->
	<link href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/nucleo-icons.css" rel="stylesheet">
	<link href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/nucleo-svg.css" rel="stylesheet">
	<!-- Font Awesome Icons -->
	<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
	<!-- CSS Files -->
	<link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css?v=1.1.0') }}" rel="stylesheet">
	<!-- Nepcha Analytics (nepcha.com) -->
	<!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
	<script defer="" data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
	<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>

<body class="g-sidenav-show bg-gray-100">
	<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3"
		id="sidenav-main">
		@include('components.header')
	</aside>

	<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
		@include('components.content_top')
		<div class="container m-0 p-0">
			<div class="col-md-12">
				<form action="{{ url('/editors') }}" method="GET" class="d-flex">
					<div class="col-md-3">
						<input type="date" name="month" value="" class="form-control">
					</div>
					<div class="col-md-2">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
		<div class="col-md-12">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<td>項目</td>
						<td>ファイル名</td>
						<td>デッドライン</td>
						<td>状態</td>
						<td>優先度</td>
						<td>操作</td>
					</tr>
				</thead>
				<tbody>
					@foreach ($files as $file)
						<form action="{{ url('/editors/edit/' . $file->id) }}" method="POST">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<tr>
								<td>{{ $file->id }}</td>
								<td>{{ $file->filename }}</td>
								<td>{{ $file->deadline }}</td>
								@if ($file->status != 1)
									<td><input type="checkbox" name="status" checked></td>
								@else
									<td><input type="checkbox" name="status"></td>
								@endif
								<td>{{ $file->priority }}</td>
								<td>
									@if ($file->status != 1)
										<button class="btn btn-primary disabled">Edit</button>
									@else
										<button class="btn btn-primary">Edit</button>
									@endif
									<a href="#" class="btn btn-primary">Download</a>
									<label class="btn btn-primary" for="choose_file_1">Upload</label>
									<input type="file" name="file" style="display: none" id="choose_file_1">
								</td>
							</tr>
						</form>
					@endforeach
				</tbody>
			</table>
			<div class="paginate">
				{!! $files->links() !!}
			</div>
		</div>
	</main>

	<!--   Core JS Files   -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
		integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
		crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
	<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
	<!-- Github buttons -->
	<script async="" defer="" src="https://buttons.github.io/buttons.js"></script>
	<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
	<script src="{{ asset('assets/js/soft-ui-dashboard.min.js?v=1.1.0') }}"></script>
</body>

</html>