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
							<button style="height: 40px;" type="submit" class="btn btn-primary">検索</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-12" id="btn-action-import-export">
		<a href="{{ url('/statistic/export') }}" class="btn btn-primary">エクスポート</a>
		<a href="{{ url('/statistic/import') }}" class="btn btn-primary">インポート</a>
	</div>

	<table class="table table-hover table-bordered">
		<thead>
			<th>#</th>
			<th>名前</th>
			<th>メール</th>
			<th>完了</th>
			<th>支払い状況</th>
			<th>給料</th>
			<th>操作</th>
		</thead>
		<tbody>
			<tr>
				<td>1</td>
				<td>2</td>
				<td>3</td>
				<td>4</td>
				<td>5</td>
				<td>6</td>
				<td>
					<a href="#" class="btn btn-primary">有料</a>
				</td>
			</tr>
		</tbody>
	</table>
@endsection