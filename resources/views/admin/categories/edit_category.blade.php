@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Categories</a> <a href="#" class="current">Edit Category</a> </div>
    <h1>Categories</h1>
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Edit Category</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form-horizontal" method="post"enctype="multipart/form-data" action="{{url('/admin/edit_category/'.$categoryDetails->id)}}" name="edit_category" id="edit_category" novalidate="novalidate">
               {{ csrf_field()}}
              <div class="control-group">
                <label class="control-label">Category Name</label>
                <div class="controls">
                  <input type="text" name="category_name" id="category_name" value="{{$categoryDetails->category_name}}">
                </div>
              </div>
               <div class="control-group">
                <label class="control-label">Category Level</label>
              <div class="controls">
                  <select name="parent_id" style="width: 220px;">
                    <option value="0">Main Category</option>
                    @foreach($levels as $val)
                      <option value="{{ $val->id }}" @if($val->id == $categoryDetails->parent_id) selected @endif>{{ $val->category_name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Description</label>
                <div class="controls">
                  <textarea type="text" name="description" id="description">{{$categoryDetails->description}}</textarea>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">URL</label>
                <div class="controls">
                  <input type="text" name="url" id="url" value="{{$categoryDetails->url}}" >
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Enable</label>
                <div class="controls">
                  <input type="checkbox" name="status" id="status" @if($categoryDetails->status=="1") checked @endif value= "1">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Activate to Landing Page</label>
                <div class="controls">
                  <input type="checkbox" name="activate_categories" id="activate_categories"  @if($categoryDetails->activate_categories=="1") checked @endif value= "1">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Image</label>
                <div class="controls">
                    <input name="image" id="image" type="file">
                      <input type="hidden" name="current_image" value="{{ $categoryDetails->image }}"> 
                  @if(!empty($categoryDetails->image))
                  <img style="width::40px; height: 50px;" src="{{ asset('/images/backend_images/categories/small/'.$categoryDetails->image) }}">| <a href="{{ url('/admin/delete_product_image/'.$categoryDetails->id) }}">Delete</a>
                  @endif
                </div>
              </div>              
              <div class="form-actions">
                <input type="submit" value="Edit Category" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection