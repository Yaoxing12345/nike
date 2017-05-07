@extends('layouts.app')

@section('content')


<div class="container">


    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Convert Your currency
                  <span class ="col-md-2 button" ><a href="/currency-list">currency list</a></span>
                  
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/currency-converter') }}">
                        <div class="form-group">
                           <label for="c_from" class="col-md-4 control-label">From Country</label>
                           <div class="col-md-6">
                               <select class="form-group" name="c_from" id="c_from" required>
                                    <option value="">select</option>
                                  @foreach($cd_data as $k => $v)
                                      <option value="{{$k}}">{{$v}}</option>
                                  @endforeach
                                </select> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="to_country" class="col-md-4 control-label">To Country</label>
                            <div class="col-md-6">
                                <select class="form-group" name="to_country" id="to_country" required>
                                    <option value="" ="">Select</option>
                                  @foreach($cd_data as $k => $v)
                                      <option value="{{$k}}">{{$v}}</option>
                                  @endforeach
                                </select> 
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="c_amount" class="col-md-4 control-label">Enter Amount</label>
                            <div class="col-md-6">
                                <input id="c_amount" type="number" class="form-control" name="c_amount" value="{{ old('c_amount') }}" required>
                            </div>
                        </div>
                        <div class="form-group hidden-class" id="converted-value">
                            
                           
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
