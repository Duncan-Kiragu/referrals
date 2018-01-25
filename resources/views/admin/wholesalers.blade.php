@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">All Wholesalers</div>

                <div class="panel-body">

                    <p><a href="{{route('admin.wholesaler.add')}}">Add Wholesaler Role to a User</a></p>
                    <table class = "referrals">
                      <thead>
                        <tr>
                          <th>
                            Wholesaler Email
                          </th>
                          <th>
                            Actions
                          </th>
                          <th>
                            Remove
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($wholesalers as $wholesaler)
                          <tr>
                            <td>
                              {{$wholesaler->email}}
                            </td>
                            <td>
                              <a href="{{route('admin.wholesalers_single', ['user_id' => $wholesaler->id])}}">VIEW</a>
                            </td>
                            <td>
                              <a href="{{route('admin.wholesaler.remove', ['user_id' => $wholesaler->id])}}">Remove Wholesaler Role</a>
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
