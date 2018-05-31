@extends('layouts.app')

@section('content')
<div class="container">
  @include('includes.info-box')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">List of All Referrals for {{$user->name}} - {{$user->email}}</div>



                <div class="panel-body">
                  <p>Referral Link: <a href = "http://sustainablediet.com/?ref={{$user->id}}">http://sustainablediet.com/?ref={{$user->id}}</a></p>
                  <p><a href="{{route('admin.referrals.download', ['user_id' => $user->id])}}">Download CSV</a></p>
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
                      <th>
                        Referral Type
                      </th>
                      <th>
                        Actions
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
                        <td>
                          ${{$referral->referral_type}}
                        </td>
                        <td>
                          <a href = "{{route('admin.referral.delete', ['referral_id' => $referral->id ])}}">Delete</a>
                        </td>
                      </tr>

                    @endforeach
                  </table>



                  <p>&nbsp;</p>
                  <h3>
                    List of Affiliates
                  </h3>

                  <table class="referral-table">
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

                    @foreach($referrers as $referrer)

                      <tr>
                        <td>
                          {{$referrer->name}}
                        </td>
                        <td>
                          {{$referrer->email}}
                        </td>
                        <td>
                          <a href="{{route('admin.referrers_single', ['user_id' => $referrer->id])}}" style = "margin-right:20px;">VIEW</a>
                          <a href="{{route('admin.wholesaler.removeaffiliate', ['user_id' => $referrer->id])}}" onclick="return confirm('Are you sure you want to remove this affiliate?');">REMOVE AFFILIATE</a>
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
