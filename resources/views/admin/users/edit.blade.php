@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id=" content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Users</a> <a href="#" class="current">Edit Product</a> </div>
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
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Edit User</h5>
          </div>
          <div class="widget-content nopadding">
            <form  class="form-horizontal" method="post" action="{{url('/admin/edit_user/'.$userDetails->id)}}" name="edit_user" id="edit_user" novalidate="novalidate">
              @csrf
                <div class="control-group">
                    <label class="control-label">Name</label>
                    <div class="controls">
                    <input type="text" name="name" id="name" value="
                    {{$userDetails->name}}" required>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Email</label>
                    <div class="controls">
                    <input type="email" name="email" id="email" value="
                    {{$userDetails->email}}" required>
                    </div>
                </div>
              <div class="form-actions">
                <input type="submit" value="Edit User" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
