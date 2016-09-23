@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">All Wholesalers</div>

                <div class="panel-body">

                    <p><a href="{{route('admin.wholesaler.add')}}">Add Wholesaler</a></p>
                    <table class = "referrals">
                      <tr>
                        <th>
                          Wholesaler Email
                        </th>
                      </tr>
                      @foreach($wholesalers as $wholesaler)
                        <tr>
                          <td>
                            {{$wholesaler->email}}
                          </td>
                          <td>
                            <a href="{{route('admin.wholesalers_single', ['user_id' => $wholesaler->id])}}">VIEW</a>
                            <a href="{{route('admin.wholesaler.remove', ['user_id' => $wholesaler->id])}}">Remove Wholesaler Role</a>
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
