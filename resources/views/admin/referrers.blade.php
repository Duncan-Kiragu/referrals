@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Admin Dashboard</div>

                <div class="panel-body">
                    <p>
                      All Affiliates
                    </p>

                    <table class = "referrals">
                      <tr>
                        <th>
                          Affiliate Email
                        </th>
                      </tr>
                      @foreach($referrers as $referrer)
                        <tr>
                          <td>
                            {{$referrer->email}}
                          </td>
                          <td>
                            <a href="{{route('admin.referrers_single', ['user_id' => $referrer->id])}}">VIEW</a>
                          </td>
                        </tr>
                      @endforeach

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
