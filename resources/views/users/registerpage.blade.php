@extends('layouts.frontLayout.front_design')
@section('content')
<?php
use App\Http\Controllers\Controller;
$getMenu = Controller::getMenu();

?>
<!-- Content -->
<div id="content">
<!-- Section -->
<section class="section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 push-lg-4">
                <span class="icon icon-xl icon-success"><i class="ti ti-check-box"></i></span>
                <h4 class="text-muted mb-5">Registration Succesfull...</h4>
                <a href="{{url('/menu-list-navigation/'.$getMenu->id)}}" class="btn btn-outline-secondary"><span>Go to menu</span></a>
            </div>
        </div>
    </div>
</section>
</div>
<!-- Content / End -->
<!-- Body Overlay -->
<div id="body-overlay"></div>

@endsection