@extends('layouts.frontLayout.front_design')
@section('content')
    <!-- Content -->
    <div id="content">

        <!-- Page Title -->
        <div class="page-title bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 push-lg-4">
                        <h1 class="mb-0">Menu List</h1>
                        <h4 class="text-muted mb-0">Some informations about our restaurant</h4>
                    </div>
                </div>
            </div>
        </div>

         <!-- Page Content -->
        <div class="page-content">
            <div class="container">
                <div class="row no-gutters">
                    <div class="col-md-3">
                        <!-- Menu Navigation -->
                        <nav id="menu-navigation" class="stick-to-content" data-local-scroll>
                            <ul class="nav nav-menu bg-dark dark">
                                @foreach($mainCategories as $category)
                                    <li><a href="#menuCat{{$category->url}}">{{$category->category_name}}</a></li>
                                @endforeach    
                            </ul>
                        </nav>
                    </div>
                    <div class="col-md-9">
                        <!-- Menu Category / menuCat -->
                        @foreach($mainCategories as $category)
                            <div id="menuCat{{$category->url}}" class="menu-category">
                                <div class="menu-category-title">
                                    <div class="bg-image"><img src="{{ asset('/storage/images/categories/'.$category->image) }}" alt=""></div>
                                    <h2 class="title">{{$category->category_name}}</h2>
                                </div>
                                <div class="menu-category-content padded">
                                    <div class="row gutters-sm">
                                        @foreach($category->products as $item)
                                        <div class="col-lg-4 col-6">
                                            <!-- Menu Item -->
                                            <div class="menu-item menu-grid-item">
                                                <img class="mb-4" src="{{ asset('/storage/images/products/'.$item->image) }}" alt="">
                                                <h6 class="mb-0">{{$item->product_name}}</h6>
                                                <span class="text-muted text-sm">{{$item->description}}</span>
                                                <div class="row align-items-center mt-4">
                                                    <div class="col-sm-6"><span class="text-md mr-4">Ksh. {{$item->price}}</span></div>
                                                    <form name="addtocartForm" id="addtocartForm{{ $item->id }}" action="{{url('add-to-cart/'.$item->id)}}" method="post">
                                                        {!! csrf_field() !!}
                                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                                        <input type="hidden" name="product_name" value="{{ $item->product_name }}">
                                                        <input type="hidden" name="price" id="price{{ $item->id }}" value="{{ $item->price }}">
                                                        <div class="col-sm-6 text-sm-right mt-2 mt-sm-0"><button type="submit" class="btn btn-outline-secondary btn-sm" data-target="#productModal" data-toggle="modal"><span>Add to cart</span></button></div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content / End -->
@endsection
