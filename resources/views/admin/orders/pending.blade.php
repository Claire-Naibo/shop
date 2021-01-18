@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Pending Orders</a> <a href="#" class="current">View Orders</a> </div>
    <h1>Pending Orders</h1>
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
    <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>View Pending Orders</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table table-responsive" id="myOrders">
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Customer Name</th>
                  <th>Customer Number</th>
                  <th>Customer Email</th>
                  <th>Food Ordered</th>
                  <th>Quantity</th>
                  <th>Item Price</th>
                  <th>Total</th>
                  <th>Date Ordered</th>
                </tr>
              </thead>
              <tbody>
                @foreach($orders as $order)
                <tr class="gradeX">
                  <td>{{$order->id}}</td>
                  <td>{{$order->name}}</td>
                  <td>{{$order->mobile}}</td>
                  <td>{{$order->email}}</td>
                  <td>
                    @foreach($order->orderItems as $item)
                      {{ '- ' . $item->product->product_name}}  <br/>
                    @endforeach
                  </td>
                  <td>
                    @foreach($order->orderItems as $item)
                      {{$item->quantity}} <br/>
                    @endforeach
                  </td>
                  <td>
                    @foreach($order->orderItems as $item)
                      {{ 'Ksh. ' . $item->price }} <br/>
                    @endforeach
                  </td>
                  <td>Ksh. {{$order->total}}</td>
                  <td>{{date('jS l, F Y h:i A',strtotime($order->created_at ))}}</td>
                
                </tr>
                     <div id="myModal" class="modal hide">
                      <div class="modal-header">
                        <button data-dismiss="modal" class="close" type="button">×</button>
                        <h3>Order Details</h3>
                      </div>
                      <div class="modal-body">
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
</div>
@endsection