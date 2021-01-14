@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id=" content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Products</a> <a href="#" class="current">Add Product  Attributes</a> </div>
    <h1>Products Attributes</h1>
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
            <h5>Add Category Accompaniment</h5>
          </div>
          <div class="widget-content nopadding">
            <form  enctype="multipart/form-data" class="form-horizontal" method="post" action="{{url('/admin/add_attributes/'.$productDetails->id)}}" name="add_attributes" id="add_attributes">
              {{ csrf_field()}}
              <input type="hidden" name="product_id" value="{{$productDetails->id}}">
              <input type="hidden" name="category_id" value="{{$productDetails->category_id}}">
              <div class="control-group">
                <label class="control-label">Product Name</label>
                <label class="control-label"><strong >{{$productDetails->product_name}}</strong></label>
              </div>
                 <div class="control-group">
                <label class="control-label">Product Code</label>
                <label class="control-label"><strong><p>{{$productDetails->product_code}}</p></strong></label>
              </div>
              <div class="control-group">
                <label class="control-label"></label>
                <div class="field_wrapper">
                  <div>
                    <input type="text" name="accompaniment[]" id="accompaniment" placeholder="add accompaniment" style="width: 120px"  />
                    <input type="text" name="size[]" id="size" placeholder="Size" style="width: 120px"  />
                    <input  type="text" name="price[]" id="price" placeholder="Price" style="width: 120px"  />
                  </div>
                </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="Add Attributes" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>View Category Accompaniment</h5>
          </div>
          <div class="widget-content nopadding">
            <form action="{{url('/admin/edit_attributes/'.$productDetails->id)}}" method="post">
              {{csrf_field()}}
                <table class="table table-bordered data-table">
                  <thead>
                    <tr>
                      <th>Attribute ID</th>
                      <th>Accompaniment</th>
                      <th>Size</th>
                      <th>Price</th>
                       <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($productDetails['attributes'] as $attribute)
                    <tr class="gradeX">
                      <td><input type="hidden" name="idAttr[]" value="{{$attribute->id}}">{{$attribute->id}}</td>
                      <td>{{$attribute->accompaniment}}</td>
                      <td>{{$attribute->size}}</td>
                      <td><input type="text" name="price[]" value="{{$attribute->price}}"></td>
                      <td class="center">
                          <input type="submit" value="update" class="btn btn-primary btn-mini">
                          <a rel="{{ $attribute->id }}" rel1="delete_attribute" href ="javascript:" class="btn btn-danger btn-mini deleteRecord">Delete</a>
                      </td>
                    </tr>   
                  </div>
                  @endforeach
                  </tbody>
                </table>
            </form> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection