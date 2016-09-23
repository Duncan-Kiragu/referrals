@extends('layouts.app')

@section('content')
<div class="container">
    @include('includes.info-box')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Add Wholesaler Role</div>

                <div class="panel-body">

                  <form action="{{route('admin.wholesaler.referrer.link')}}" method="post">

                    <div class="input-group">
                      <label for="referrer">Affiliate to Add:&nbsp;&nbsp;&nbsp;</label>
                      <select class="" name="referrer">
                        @foreach($referrers as $referrer)
                          <option value="{{$referrer->id}}">{{$referrer->name}} - {{$referrer->email}}</option>
                        @endforeach
                      </select>
                    </div>

                    <div class="input-group">
                      <label for="wholesaler">Add Wholesaler:&nbsp;&nbsp;&nbsp;</label>
                      <select class="" name="wholesaler">
                        @foreach($wholesalers as $wholesaler)
                          <option value="{{$wholesaler->id}}">{{$wholesaler->name}} - {{$wholesaler->email}}</option>
                        @endforeach
                      </select>
                    </div>



                    <input type="hidden" name="_token" value="{{Session::token()}}">
                    <button type="submit" class = "btn">Submit</button>
                  </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
