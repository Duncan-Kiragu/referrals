@extends('layouts.app')

@section('content')
<div class="container">
    @include('includes.info-box')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Referrals for for {{$user->name}} ({{$user->email}})</div>

                <div class="panel-body">

                  @role('referrer')
                    <p>Affiliate Referral Link: <a href = "http://www.theplantbasedlife.com/plantbasedlifedev?ref={{$user->id}}">http://www.theplantbasedlife.com/plantbasedlifedev?ref={{$user->id}}</a></p>
                    <p>
                      <a href="{{route('referrals.download', ['user_id' => $user->id])}}">Download CSV</a>
                    </p>
                    <table class="referral-table">
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
                      </tr>

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
                        </tr>

                      @endforeach
                    </table>
                    <br>
                    <br>
                    <p>
                      Referral Totals to Date: {{DB::table('referrals')->where('user_id', '=', $user->id)->count('referral_amount')}} Referrals - ${{DB::table('referrals')->where('user_id', '=', $user->id)->sum('referral_amount')}}
                    </p>


                  @endrole

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
