@extends('layouts.frontLayout.front_design')
@section('content')
    <!-- Content -->
    <div id="content">

        <!-- Section - Main -->
        <section class="section section-main section-main-2 bg-dark dark">

            <div id="section-main-2-slider" class="section-slider inner-controls">
                <!-- Slide -->
                @foreach($categories as $category)
                <div class="slide">
                    <div class="bg-image zooming"><img src="assets/img/photos/slider-burger_dark.jpg" alt=""></div>
                    <div class="container v-center">
                        <h1 class="display-2 mb-2">{{$category->category_name}}</h1>
                        <h4 class="text-muted mb-5">and use it with your next order!</h4>
                        <a href="page-offers.html" class="btn btn-outline-primary btn-lg"><span>Get it now!</span></a>
                    </div>
                </div>
                @endforeach
            </div>

        </section>
        <!-- Section - Offers -->
        <section class="section bg-light">

            <div class="container">
                <h1 class="text-center mb-6">Special offers</h1>
                <div class="carousel" data-slick='{"dots": true}'>
                    <!-- Special Offer -->
                    <div class="special-offer">
                        <img src="assets/img/photos/special-burger.jpg" alt="" class="special-offer-image">
                        <div class="special-offer-content">
                            <h2 class="mb-2">Free Burger</h2>
                            <h5 class="text-muted mb-5">Get free burger from orders higher that Ksh. 1500!</h5>
                            <ul class="list-check text-lg mb-0">
                                <li>Only on Tuesdays</li>
                                <li class="false">Order higher that Ksh. 1500</li>
                                <li>Unless one burger ordered</li>
                            </ul>
                        </div>
                    </div>
                    <!-- Special Offer -->
                    <div class="special-offer">
                        <img src="assets/img/photos/special-pizza.jpg" alt="" class="special-offer-image">
                        <div class="special-offer-content">
                            <h2 class="mb-2">Free Small Pizza</h2>
                            <h5 class="text-muted mb-5">Get free burger from orders higher that Ksh. 1500!</h5>
                            <ul class="list-check text-lg mb-0">
                                <li>Only on Weekends</li>
                                <li class="false">Order higher that Ksh. 1500</li>
                            </ul>
                        </div>
                    </div>
                    <!-- Special Offer -->
                    <div class="special-offer">
                        <img src="assets/img/photos/special-dish.jpg" alt="" class="special-offer-image">
                        <div class="special-offer-content">
                            <h2 class="mb-2">Chip Friday</h2>
                            <h5 class="text-muted mb-5">10% Off for all dishes!</h5>
                            <ul class="list-check text-lg mb-0">
                                <li>Only on Friday</li>
                                <li>All products</li>
                                <li>Online order</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- Section - Steps -->
        <section class="section section-extended left dark">

            <div class="container bg-dark">
                <div class="row">
                    <div class="col-md-4">
                        <!-- Step -->
                        <div class="feature feature-1 mb-md-0">
                            <div class="feature-icon icon icon-primary"><i class="ti ti-shopping-cart"></i></div>
                            <div class="feature-content">
                                <h4 class="mb-2"><a href="menu-list-collapse.html">Pick a dish</a></h4>
                                <p class="text-muted mb-0">Vivamus volutpat leo dictum risus ullamcorper condimentum.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- Step -->
                        <div class="feature feature-1 mb-md-0">
                            <div class="feature-icon icon icon-primary"><i class="ti ti-wallet"></i></div>
                            <div class="feature-content">
                                <h4 class="mb-2">Make a payment</h4>
                                <p class="text-muted mb-0">Vivamus volutpat leo dictum risus ullamcorper condimentum.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- Step -->
                        <div class="feature feature-1 mb-md-0">
                            <div class="feature-icon icon icon-primary"><i class="ti ti-package"></i></div>
                            <div class="feature-content">
                                <h4 class="mb-2">Recieve your food!</h4>
                                <p class="text-muted mb-3">Vivamus volutpat leo dictum risus ullamcorper condimentum.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <!-- Section - Menu -->
        <section class="section pb-0">

            <div class="container">
                <h1 class="mb-6">Our menu</h1>
            </div>

            <div class="menu-sample-carousel carousel inner-controls" data-slick='{
                "dots": true,
                "slidesToShow": 3,
                "slidesToScroll": 1,
                "infinite": true,
                "responsive": [
                            {
                                "breakpoint": 991,
                                "settings": {
                                    "slidesToShow": 2,
                                    "slidesToScroll": 1
                                }
                            },
                            {
                                "breakpoint": 690,
                                "settings": {
                                    "slidesToShow": 1,
                                    "slidesToScroll": 1
                                }
                            }
                        ]
                    }'>
                <!-- Menu Sample -->
                @foreach($categories as $category)
                    <div class="menu-sample">
                        <a href="{{url('/menu-list-navigation')}}">
                            <img src="{{ asset('/storage/images/categories/'.$category->image) }}" alt="" class="image">
                            <h3 class="title">{{$category->category_name}}</h3>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
    <!-- Content / End -->
@endsection   


