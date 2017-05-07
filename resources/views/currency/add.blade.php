@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Add New Currency</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/post-currency') }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Currency Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Code( Max 3 Chars )</label>
							<div class="col-md-6">
								<input type="text" pattern="[A-Z]{3}" class="form-control" name="code" value="{{ old('code') }}" style="text-transform:uppercase" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Symbol</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="symbol" value="{{ old('symbol') }}" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Conversion Rate ( Base US )</label>
							<div class="col-md-6">
								<input type="number" step="any" class="form-control" name="base_usd_amount" value="{{ old('base_usd_amount') }}" required>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Add Currency
								</button>
								<button type="reset" class="btn btn-primary">
									Reset
								</button>
							</div>

						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
