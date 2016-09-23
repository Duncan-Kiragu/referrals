@extends('layouts.app')

@section('content')
<div class="container">
    @include('includes.info-box')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Add a Referral</div>

                <div class="panel-body">

                  <form action="{{route('admin.referral.create')}}" method="post">

                    <div class="input-group">
                      <label for="referrer">Referrer:&nbsp;&nbsp;&nbsp;</label>
                      <select class="" name="referrer">
                        @foreach($referrers as $referrer)
                          <option value="{{$referrer->id}}">{{$referrer->name}} - {{$referrer->email}}</option>
                        @endforeach
                      </select>
                    </div>

                    <div class="input-group">
                      <label for="referral_email">Email of Referred Customer:&nbsp;&nbsp;&nbsp;</label>
                      <input type="text" name="referral_email">
                    </div>

                    <div class="input-group">
                      <label for="amount">Referral Amount:&nbsp;&nbsp;&nbsp;</label>
                      <input type="text" name = "amount" placeholder="Format: 100.00">
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
