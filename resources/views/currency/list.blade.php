@extends('layouts.app')

@section('content')


<div class="container-fluid">
  <div class="row">
    <div>
      <div class="panel panel-default">
        <div class="container">
          <h2><a href="{{ url('/add-currency') }}">Add New Currency</a></h2>
          @if (count($cd_data) > 0)
          <div class = "table">
              <div class="tr">
                @foreach ($cd_data[0] as $key => $value)
                  <div class="td col-head">{{$key}}</div>

                @endforeach
                <div class="td col-head">Action</div>
              </div>
              @foreach ($cd_data as $key => $dataArr)
              <div class="tr">
                @foreach ($dataArr as $row => $value) 
                  <div class="td">{{$value}}</div>
                @endforeach
                @if($dataArr['status'] == 1)
                  <div class="td">
                    <a href="/currency-edit-form/<?php echo $dataArr['ID']; ?>">edit</a>
                    <a href="/currency-toggle/{{ $dataArr['ID']}}/0" class = "confirm-delete">delete</a>
                  </div>
                @else
                    <a href="/currency-toggle/{{ $dataArr['ID']}}/1" class = "confirm-delete">activate</a>
                @endif
              </div>
              @endforeach
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>


@endsection
