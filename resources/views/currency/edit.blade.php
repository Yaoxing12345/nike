@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">You can edit only Currency Conversion Value</div>
				<div class="panel-body">
					@if (count($details) > 0)
						<form class="form-horizontal" role="form" method="POST" action="{{ url('/currency-edit') }}">
							<input type="hidden" name="id" value="{{ $details['id'] }}">
							<div class="form-group">
								<label class="col-md-4 control-label">Currency Name</label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="name" value="{{ $details['name'] }}" disabled>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Code</label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="code" value="{{ $details['code'] }}" disabled>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Symbol</label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="symbol" value="{{ $details['symbol'] }}" disabled>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Conversion Rate ( Base US )</label>
								<div class="col-md-6">
									<input type="number" step="any" class="form-control" name="base_usd_amount" value="{{ $details['base_usd_amount'] }}">
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<button type="submit" class="btn btn-primary">
										Edit Currency
									</button>
									<button type="reset" class="btn btn-primary">
										Reset
									</button>
								</div>
							</div>
						</form>
					
					@else
						<div class="panel-heading">Oops..No Details found..!!</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
