@extends('layouts.frontLayout.front_design')
@section('content')

    <!-- Content -->
    <div id="content">

        <div class="jumbotron jumbotron-fluid menu-component">
            <h3 class="text-center menu-header">Checkout Now</h3>
        </div>

        <!-- Section -->
        <section class="section bg-light">

            <div class="container">
                <div class="row">
                    <div class="col-xl-4 push-xl-8 col-lg-5 push-lg-7 mr-auto">
                        <div class=" card shadow bg-white">
                            <div class="bg-dark dark p-4"><h5 class="mb-0">You order</h5></div>
                            <div class="card-body">
                                <div class="row">
                                    <table class="table-cart">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th >Price</th>
                                                <th >Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php $total = 0 ?>
                                        @if(session('cart'))
                                            @foreach(session('cart') as $id => $details)
                                            <?php $total += $details['price'] * $details['quantity']; ?>
                                            <tr>
                                                <td class="title">
                                                    <span class="name">{{ $details['product_name'] }}</span><br/>

                                                    <form action="{{url('/cart/update-cart/'.$id)}}" method="post">
                                                        {!! csrf_field() !!}
                                                        <input name="quantity" style="width: 50px;" type="number" value="{{ $details['quantity'] }}" class="name" min="1" max="10" /><br />
                                                        @if(!empty($details['accompaniment']))
                                                            <span class="name"> + {{ $details['accompaniment'] }} {{ $details['accompaniment_price'] ? '(Ksh. ' . $details['accompaniment_price'] . ')' : '' }}</span>
                                                        @endif
                                                        @if(!empty($details['accompaniment_size']))
                                                            <span class="name">Size : {{$details['accompaniment_size']}}</span>
                                                        @endif
                                                </td>
                                                <td id="getPrice" class="price">Ksh. {{ $details['price'] }} </td>
                                                <td id="itemTotal" class="price">Ksh. {{ $details['price'] * $details['quantity'] }} </td>
                                                <td class="actions">
                                                        {{-- <a href="{{url('/cart/update-cart/'.$id)}}" class="action-icon" ><i class="fa fa-refresh"></i></a> --}}
                                                        <button  class="action-icon" type="submit" style="background: none; padding: 0px; border: none;"><i style="color: #808080;"class="fa fa-refresh"></i></button>
                                                        <br />
                                                        {{-- <input type="hidden" name="cartId" value="{{$id}}" /> --}}
                                                    </form>
                                                    <br><br>
                                                    <a href="{{url('/cart/delete_cart/'.$id)}}" class="action-icon" ><i class="ti ti-close"></i></a>
                                                </td>

                                            </tr>
                                            @endforeach
                                        @endif
                                </table>
                                </div>
                                <div class="cart-summary">
                                    {{--<div class="row">--}}
                                    {{--<div class="col-7 text-right text-muted">Order total:</div>--}}
                                    {{--<div class="col-5"><strong>Ksh. {{$total }}</strong></div>--}}
                                    {{--</div>--}}                                    
                                    <div class="row text-md bottom-button">

                                        <div class="col-7 ml-auto"><strong>Total</strong></div>
                                        <div class="col-5 mr-auto" id="totalDisplay"><strong>Ksh. {{ $total }}</strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        </div>
                            <br>
                            <br>
                            <br>
                    <div class="col-xl-8 pull-xl-4 col-lg-7 pull-lg-5">
                        <div>
                            <form action="{{url('/billing')}}" method="POST" enctype="multipart/form-data" id="checkoutForm" data-validate>
                            @csrf
                                <h4 class="border-bottom pb-4"><i class="ti ti-user mr-3 text-primary"></i>Customer Information</h4>
                                <div>
                                    <div class="form-group">
                                        <label>Name:</label>
                                        <input type="text" name="name" class="form-control" value="{{ auth()->user() ? auth()->user()->name : '' }}" placeholder="e.g. John Doe" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Phone number<small>(e.g. 711222333)</small>:</label>
                                        <input type="text" name="mobile" class="form-control" value="{{ auth()->user() ? auth()->user()->mobile : '' }}" placeholder="e.g. 711222333" minlength="9" maxlength="9">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>E-mail address:</label>
                                        <input type="email" name="email" class="form-control" value="{{ auth()->user() ? auth()->user()->email : '' }}" placeholder="e.g. johndoe@email.com" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Address:</label>
                                        <input type="text" name="address" class="form-control" value="{{ auth()->user() ? auth()->user()->address : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label>City:</label>
                                        <input type="text" name="city"  class="form-control" value="{{ auth()->user() ? auth()->user()->city : '' }}">
                                    </div> 
                                    <div class="form-group" >
                                        <label>Country Code:</label>
                                        <select class="form-control" name="country_code">
                                            <option value="254">Kenya (+254)</option>
                                        </select>
                                    </div>
                                    <input type="hidden" id="total" name="total" value="{{ $total }}" />
                                </div>
                        </div>
                        <br>
                                @if(session('cart'))
                                    <button class="utility-box-btn btn btn-primary btn-block btn-block btn-lg btn-submit" type="submit" id="orderSubmit">Order Now
                                    </button>
                                @else
                                <button class="utility-box-btn btn btn-danger btn-block btn-block btn-lg btn-submit" type="submit" id="orderSubmit">
                                    <span class="description">Please add an item to your cart first.</span>
                                </button>
                                @endif
                            </form>
                            <br><br><br>
                            @if(!auth()->user())
                                <div class="form-group col-md-12">
                                    <br />
                                    <p class="text-center">Already have an account? Click the button below to proceed.</p>
                                </div>
                                <div class="form-group col-md-12">
                                    <a class="btn btn-info" style="width: 100%;" href="#loginHeaderModal" data-toggle="modal" ><span>Login</span></a>
                                </div>
                            @endif
                        </div>
                    </div>


                </div>
            </div>

        </section>

    </div>

@endsection
