<!--sidebar-menu-->
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
 <ul>
    <li class="active"><a href="{{url('/admin/dashboard')}}"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Categories</span> <span class="label label-important"></span></a>
      <ul>
        <li><a href="{{url('/admin/categories/add_category')}}">Add Category</a></li>
        <li><a href="{{url('/admin/categories/view_category')}}">View Categories</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Products</span> <span class="label label-important"></span></a>
      <ul>

        <li><a href="{{url('/admin/add_products')}}">Add Product</a></li>
        <li><a href="{{url('/admin/products/view_products')}}">View Products</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span> Manage Orders</span> <span class="   label label-important"></span></a>
      <ul>
        <li><a href="{{url('orders/pending')}}">Pending Orders</a></li>
        <li><a href="{{url('orders/delivered')}}">Delivered Orders</a></li>
        <li><a href="{{url('orders')}}">All Orders</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span> Sliders</span> <span class="label label-important"></span></a>
      <ul>
         <li><a href="{{url('/admin/add_slider_images')}}">Add Slider Products</a></li>
        <li><a href="{{url('/admin/products/view_slider_products')}}">View Slider Products</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span> Offers</span> <span class="label label-important"></span></a>
      <ul>
        <li><a href="{{url('/admin/products/view_slider_products')}}">View Product Offers</a></li>
      </ul>
    </li>
  </ul>
</div>
<!--sidebar-menu-->
