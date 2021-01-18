<!DOCTYPE html>
<html lang="en">
<head>

<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />

<!-- Title -->
<title>Food Shop - Restaurant with Online Ordering System Template</title>

<!-- Favicons -->
<link rel="shortcut icon" href="{{asset('assets/img/favicon.png')}}">
<link rel="apple-touch-icon" href="{{asset('assets/img/favicon_60x60.png')}}">
<link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/img/favicon_76x76.png')}}">
<link rel="apple-touch-icon" sizes="120x120" href="{{asset('assets/img/favicon_120x120.png')}}">
<link rel="apple-touch-icon" sizes="152x152" href="{{asset('assets/img/favicon_152x152.png')}}">

<!-- CSS Plugins -->
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/dist/css/bootstrap.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/plugins/slick-carousel/slick/slick.css')}}" />
<link rel="stylesheet" href="{{asset('assets/plugins/animate.css/animate.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/plugins/animsition/dist/css/animsition.min.css')}}" />

<!-- CSS Icons -->
<link rel="stylesheet" href="{{asset('assets/css/themify-icons.css')}}" />
<link rel="stylesheet" href="{{asset('assets/plugins/font-awesome/css/font-awesome.min.css')}}" />

<!-- CSS Theme -->
<link id="theme" rel="stylesheet" href="{{asset('assets/css/themes/theme-beige.min.css')}}" />

</head>

<body>
    @include('layouts.frontLayout.header')

    @yield('content')

    @include('layouts.frontLayout.footer')
<!-- Body Wrapper -->
<div id="body-wrapper" class="animsition">
    <!-- Panel Cart -->
     <div id="panel-cart">
        <div class="panel-cart-container">
            <div class="panel-cart-title">
                <h5 class="title">Your Cart</h5>
                <button class="close" data-toggle="panel-cart"><i class="ti ti-close"></i></button>
            </div>
            <div class="panel-cart-content">
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
                            <span class="name">Name : {{ $details['product_name'] }}</span><br/>

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
                                <br/>
                                {{-- <input type="hidden" name="cartId" value="{{$id}}" /> --}}
                            </form>
                            <br><br>
                            <a href="{{url('/cart/delete_cart/'.$id)}}" class="action-icon" ><i class="ti ti-close"></i></a>
                        </td>

                    </tr>
                    @endforeach
                @endif
                </table>
                <div class="cart-summary">
                    <div class="row">
                        <div class="col-7 text-right text-muted">Order total:</div>
                        <div class="col-5"><strong>Ksh. {{$total }}</strong></div>
                    </div>
                    <hr class="hr-sm">
                    <div class="row text-lg">
                        <div class="col-7 text-right text-muted">Total:</div>
                        <div class="col-5"><strong>Ksh. {{$total}}</strong></div>
                    </div>
                </div>
            </div>
        </div>
        <a href="{{ url('/checkout') }}" class="panel-cart-action btn btn-secondary btn-block btn-lg"><span>Go to checkout</span></a>
    </div>

    <!-- Panel Mobile -->
    <nav id="panel-mobile">
        <div class="module module-logo bg-dark dark">
            <a href="#">
                <img src="assets/img/logo-light.svg" alt="" width="88">
            </a>
            <button class="close" data-toggle="panel-mobile"><i class="ti ti-close"></i></button>
        </div>
        <nav class="module module-navigation"></nav>
        <div class="module module-social">
            <h6 class="text-sm mb-3">Follow Us!</h6>
            <a href="#" class="icon icon-social icon-circle icon-sm icon-facebook"><i class="fa fa-facebook"></i></a>
            <a href="#" class="icon icon-social icon-circle icon-sm icon-google"><i class="fa fa-google"></i></a>
            <a href="#" class="icon icon-social icon-circle icon-sm icon-twitter"><i class="fa fa-twitter"></i></a>
            <a href="#" class="icon icon-social icon-circle icon-sm icon-youtube"><i class="fa fa-youtube"></i></a>
            <a href="#" class="icon icon-social icon-circle icon-sm icon-instagram"><i class="fa fa-instagram"></i></a>
        </div>
    </nav>

    <!-- Body Overlay -->
    <div id="body-overlay"></div>
@section('scripts')


<script type="text/javascript">

    $("#update-cart").click(function (e) {
       e.preventDefault();

       var ele = $(this);

        $.ajax({
           url: '{{ url('update-cart') }}',
           method: "patch",
           data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: ele.parents("tr").find(".quantity").val()},
           success: function (response) {
               window.location.reload();
           }
        });
    });

    $(".remove-from-cart").click(function (e) {
        e.preventDefault();

        var ele = $(this);

        if(confirm("Are you sure")) {
            $.ajax({
                url: '{{ url('remove-from-cart') }}',
                method: "DELETE",
                data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });

</script>

@endsection

<!-- JS Plugins -->
<script src="{{asset('assets/plugins/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('assets/plugins/tether/dist/js/tether.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/plugins/slick-carousel/slick/slick.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery.appear/jquery.appear.js')}}"></script>
<script src="{{asset('assets/plugins/jquery.scrollto/jquery.scrollTo.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery.localscroll/jquery.localScroll.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery.mb.ytplayer/dist/jquery.mb.YTPlayer.min.js')}}"></script>
<script src="{{asset('assets/plugins/twitter-fetcher/js/twitterFetcher_min.js')}}"></script>
<script src="{{asset('assets/plugins/skrollr/dist/skrollr.min.js')}}"></script>
<script src="{{asset('assets/plugins/animsition/dist/js/animsition.min.js')}}"></script>

<!-- JS Core -->
<script src="{{asset('assets/js/core.js')}}"></script>

</body>

</html>
