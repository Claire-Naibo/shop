@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Products</a> <a href="#" class="current">View Products</a> </div>
    <h1>Products</h1>
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
            <h5>View Products</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Category Name</th>
                  <th>Product Name</th>
                  <th>Product Code</th>
                  <th>Price</th>
                  <th>Image</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              	@foreach($products as $product)
                <tr class="gradeX">
                  <td>{{$product->category->category_name}}</td>
                  <td>{{$product->product_name}}</td>
                  <td>{{$product->product_code}}</td>
                  <td>{{$product->price}}</td>
                  <td class="center">
                  @if(!empty($product->image))
                    <img src="{{ asset('/storage/images/products/'.$product->image) }}" style="width:80px;">
                  @endif
                </td>
                  <td class="gradeX">
                    <a href="#myModal{{$product->id}}" data-toggle="modal" class="btn btn-success btn-mini" title="View Product">View</a>
                    <a href="{{url('/admin/edit_product/'.$product->id)}}" class="btn btn-primary btn-mini" title="Edit Product">Edit</a>
                    <a rel="{{ $product->id }}" rel1="delete_product" <?php /* href="{{url('/admin/delete_category/'.$product->id)}}" */?> href ="javascript:" class="btn btn-danger btn-mini deleteRecord" title="Delete Product">Delete</a>
                  </td>
                </tr>
                    <div id="myModal{{$product->id}}" class="modal hide">
                      <div class="modal-header">
                        <button data-dismiss="modal" class="close" type="button">×</button>
                        <h3>{{$product->product_name}} Full Details</h3>
                      </div>
                      <div class="modal-body">
                        <p>Category Name: {{$product->category->category_name}}</p>
                        <p>Product Code:{{$product->product_code}}</p>
                        <p>Price: {{$product->price}}</p>
                        <p>Description: {{$product->description}}</p>
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
