@extends('layouts.app')

@section('content')
<div class="container">
    @include('includes.info-box')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">

                  @role('referrer')
                    <p>Your Referral Link: <a href = "http://sustainablediet.com/?ref={{$user->id}}">http://sustainablediet.com/?ref={{$user->id}}</a></p>
                    <p>
                      <a href="{{route('referrals.download', ['user_id' => $user->id])}}">Download CSV</a>
                    </p>
                    <table class="referral-table">
                      <thead>
                        <tr>
                          <th>
                            Date/Time
                          </th>
                          <th>
                            Customer Email
                          </th>
                          <!--<th>
                            Amount
                          </th>-->
                          <th>
                            Referral Type
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
                          <!--<td>
                            ${{$referral->referral_amount}}
                          </td>-->
                          <td>
                            {{$referral->referral_type}}
                          </td>
                        </tr>

                      @endforeach
                      </tbody>
                    </table>
                    <br>
                    <br>
                    <p>
                      Referral Totals to Date: {{DB::table('referrals')->where('user_id', '=', $user->id)->count('referral_amount')}} Referrals - ${{DB::table('referrals')->where('user_id', '=', $user->id)->sum('referral_amount')}}
                    </p>


                  @endrole

                  @role('wholesaler')
                  <p>&nbsp;</p>
                  <h3>
                    List of Affiliates
                  </h3>

                  <table class="referral-table">
                    <thead>
                      <tr>
                        <th>
                          Affiliate Name
                        </th>
                        <th>
                          Affiliate Email
                        </th>

                        <th>
                          Actions
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($referrers as $referrer)

                      <tr>
                        <td>
                          {{$referrer->name}}
                        </td>
                        <td>
                          {{$referrer->email}}
                        </td>
                        <td>
                          <a href="{{route('commission.edit', ['user_id' => $referrer->id])}}">Edit Commission</a>
                          <a href="{{route('wholesaler.referrers_single', ['user_id' => $referrer->id])}}">VIEW</a>
                        </td>
                      </tr>

                    @endforeach
                    </tbody>
                  </table>
                  @endrole

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
