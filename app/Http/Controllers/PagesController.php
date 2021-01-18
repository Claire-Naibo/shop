<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use Session;
use Image;
use Auth;
use DB;

class PagesController extends Controller
{
    public function Index() {
        $categories = Category::get();
        return view('index', compact('categories'));

    }

}
