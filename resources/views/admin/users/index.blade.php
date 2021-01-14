@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Users</a> <a href="#" class="current">View Users</a> </div>
    <h1>Users</h1>
     @if(Session::has('flash_message_error'))
            <div class="alert alert-error alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{!! session('flash_message_error') !!}</strong>
            </div>
        @endif
        @if(Session::has('flash_message_success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{!! session('flash_message_success') !!}</strong>
            </div>
        @endif
  </div>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>View Users</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              	@foreach($users as $user)
                <tr class="gradeX">
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  <td class="gradeX">
                    <a href="#myModal{{$user->id}}" data-toggle="modal" class="btn btn-success btn-mini" title="View User">View</a>
                    <a href="{{url('/admin/edit_user/'.$user->id)}}" class="btn btn-primary btn-mini" title="Edit User">Edit</a>
                    <a rel="{{ $user->id }}" rel1="delete_user"  href ="javascript:" class="btn btn-danger btn-mini deleteRecord" title="Delete User">Delete</a>
                  </td>
                </tr>
                    <div id="myModal{{$user->id}}" class="modal hide">
                      <div class="modal-header">
                        <button data-dismiss="modal" class="close" type="button">×</button>
                        <h3>{{$user->name}} Full Details</h3>
                      </div>
                      <div class="modal-body">
                        <p>Full Name: {{$user->name}}</p>
                        <p>Email: {{$user->email}}</p>
                      </div>
                    </div>

                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
  </div>
</div>

@endsection
