@extends('layouts.app')

@section('content')
<div class="container">
  @include('includes.info-box')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">List of All Referrals for {{$user->name}} - {{$user->email}}</div>



                <div class="panel-body">

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
                      @if($user->wholesaler_id != NULL)
                        <th>
                          Commission
                        </th>
                      @endif
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
                          {{$referral->referral_type}}
                        </td>
                        @if($user->wholesaler_id != NULL)
                          <th>
                            ${{$referral->referral_amount * ($user->percentage/100) }}
                          </th>
                        @endif
                        <td>
                          <a href = "{{route('admin.referral.delete', ['referral_id' => $referral->id ])}}">Delete</a>
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
