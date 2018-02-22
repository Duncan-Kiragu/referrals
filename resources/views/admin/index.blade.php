@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Admin Dashboard</div>

                <div class="panel-body">


                    <ul>
                      <li><a href = "{{route('admin.wholesalers')}}">All Partners</a></li>
                      <li><a href = "{{route('admin.referrers')}}">All Affiliates</a></li>
                      <li><a href = "{{route('admin.referral.add')}}">Add a Referral</a></li>
                      <li><a href = "{{route('admin.wholesaler.referrer.add')}}">Link Affiliate to Partner</a></li>
                    </ul>

                    <h3>Recent Referrals</h3>

                    <table class="referral-table">
                      <thead>
                        <tr>
                          <th>
                            Date/Time
                          </th>
                          <th>
                            Customer Email
                          </th>
                          <th>
                            Amount
                          </th>
                          <th>
                            Referral Type
                          </th>
                          <th>
                            User
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach($referrals as $referral)
                        <tr>
                          <td>
                            {{$referral->created_at}}
                          </td>
                          <td>
                            {{$referral->referral_email}}
                          </td>
                          <td>
                            ${{$referral->referral_amount}}
                          </td>
                          <td>
                            {{$referral->referral_type}}
                          </td>
                          <td>
                            <a href="{{route('admin.referrers_single', ['user_id' => $referral->user_id])}}">{{$referral->user->name}}</a>
                          </td>
                        </tr>
                      @endforeach
                      </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
