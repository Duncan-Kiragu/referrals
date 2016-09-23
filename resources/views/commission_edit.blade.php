@extends('layouts.app')

@section('content')
<div class="container">
    @include('includes.info-box')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">

                  <form action="{{route('commission.save')}}" method="post">

                    <div class="input-group">
                      <label for="commission">Commission Percentage for {{$user->name}} ({{$user->email}})&nbsp;&nbsp;&nbsp;</label>
                      <input type="text" name="commission" value="{{$user->percentage}}" maxlength="3">
                    </div>

                    <input type="hidden" name="id" value="{{$user->id}}">
                    <input type="hidden" name="_token" value="{{Session::token()}}">
                    <button type="submit" class = "btn">Submit</button>
                  </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
