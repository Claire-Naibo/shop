<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Image;
use Auth;
use Session;
use DB;

class ProductsController extends Controller {
    public function addProduct(Request $request, $id = null) {

        if ($request->isMethod('post')) {
            $data = $request->all();
             //echo "<pre>";print_r($data); die;
            if(empty($data['category_id'])){
                return redirect()->back()->with('flash_message_error','Under Category is missing!');
            }
            $product = new Product;

            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            if (!empty($data['description'])) {
                $product->description = $data['description'];
            }else{
                $product->description = '';
            }
            $product->price =$data['price'];

            //Upload Image
            if($request->hasFile('image')){
                //Get file from the browser
               $path= $request->file('image');
                // Resize and encode to required type
               $img = Image::make($path)->encode();
                $img->resize(300, 200, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($filename.'/'.$request->hasFile('image'));
                //Provide the file name with extension
               $filename = time(). '.' .$path->getClientOriginalExtension();
               //Put file with own name
               Storage::put($filename, $img);
               //Move file to your location
               Storage::move($filename, 'public/images/products/' . $filename);
               //now insert into database
               $product->image = $filename;
            }
            //echo "<pre>";print_r($product);die;
            $product->save();
            return redirect('/admin/products/view_products')->with('flash_message_success','Product Added Successfuly!');

        }

        $categories = Category::where(['parent_id'=>0])->get();
        //echo "<pre>";print_r($categories);die;

        $categories_dropdown = "<option value='' selected disabled>Select</option>";
        foreach($categories as $cat){
            $categories_dropdown .= "<option value='".$cat->id."'>".$cat->category_name."</option>";
            $sub_categories = Category::where(['parent_id' => $cat->id])->get();
            foreach($sub_categories as $sub_cat){
                $categories_dropdown .= "<option value='".$sub_cat->id."'>&nbsp;&nbsp;--&nbsp;".$sub_cat->category_name."</option>";
            }
        }
        // Categories drop down end //

        return view('admin.products.add_products')->with(compact('categories_dropdown'));
    }

    public function editProduct(Request $request, $id=null) {

        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>";print_r($data);die;
            //check for current photo
            $currentPhoto = $data['current_image'];
            //Upload Image
            if ($request->image != null && $request->image != $currentPhoto) {
                //delete the image from the folder
                Storage::disk('public')->delete('images/products/'.$currentPhoto);
                //Get file from the browser
                $path= $request->file('image');
                 // Resize and encode to required type
                $img = Image::make($path)->encode();
                 //Provide the file name with extension
                $filename = time(). '.' .$path->getClientOriginalExtension();
                //Put file with own name
                Storage::put($filename, $img);
                //Move file to your location
                Storage::move($filename, 'public/images/products/' . $filename);
            }else{
              $filename = $data['current_image'];
            }

            if (empty($data['description'])) {
                $data['description'];
            }
            Product::where(['id'=>$id])->update(['category_id'=>$data['category_id'],'product_name'=>$data['product_name'],'product_code'=>$data['product_code'],'description'=>$data['description'],'price'=>$data['price'],'image'=>$filename]);

           //dd($test);die;

            return redirect('/admin/products/view_products')->with('flash_message_success', 'Product has been Updated Successfully!');

        }

        $productDetails = Product::where(['id'=>$id])->first();
        //categories dropdown start
        $categories = Category::where(['parent_id'=>0])->get();
        $categories_dropdown = "<option value='' selected disabled>Select</option>";
        foreach($categories as $cat){
            if ($cat->id==$productDetails->category_id) {
                $selected = "selected";
            }else{
                $selected = "";
            }
            $categories_dropdown .= "<option value='".$cat->id."' ".$selected.">".$cat->category_name."</option>";
            $sub_categories = Category::where(['parent_id'=>$cat->id])->get();
            foreach ($sub_categories as $sub_cat) {
            if ($cat->id==$productDetails->category_id) {
                $selected = "selected";
            }else{
                $selected = "";
            }
                $categories_dropdown .= "<option value = '".$sub_cat->id."' ".$selected.">&nbsp;--&nbsp;".$sub_cat->category_name."</option>";
            }
        }

        return view('/admin/products.edit_product')->with(compact('productDetails','categories_dropdown'));
    }

    public function viewProducts(Request $request) {

        $products = Product::with('category')->get();
        $products = json_decode(json_encode($products));
        // foreach($products as $key => $val){
        //     $category_name = Category::where(['id'=>$val->category_id])->first();
        //     $products[$key]->category_name = $category_name->category_name;
        // }
        // echo "<pre>"; print_r($products); die;
        return view('admin.products.view_products')->with(compact('products'));
    }

    public function deleteProduct($id) {
        $product = Product::findOrFail($id);
        //remove the image from the public/images folder
        Storage::disk('public')->delete('storage/images/products/'.$product->image);
        //delete the prod$product
        $product->delete();
        return redirect()->back()->with('flash_message_success','Product has been Deleted Successfully!');
    }

    public function deleteSliderProduct($id = null) {
        SliderProducts::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success','Product has been Deleted Successfully!');
    }

    public function products($id = null) {

        //get main categories
        $mainCategories = Category::with('products')->where(['parent_id'=>0])->orderBy('id','ASC')->get();
        //dd($mainCategories);
        return view('menu-list-navigation')->with(compact('mainCategories'));
    }

    public function singleProduct($id = null, $category_id='category_id'){

        //get sub categories
        $subCategories = Category::where(['parent_id' => $id])->get();
        //dd($subCategories);

        $allDetails = [];

        foreach ($subCategories as $subCategory) {

            $getCatNames = Category::with('products')->where(['id' =>$subCategory->id])->get();
            $getCatNames = json_decode(json_encode($getCatNames));
            //dd($getCatNames);
            array_push($allDetails, $getCatNames);

        }
            //dd($allSpecificDetails);
        return view('frontpages/menu-single')->with(compact('subCategories','allDetails'));
    }

    public function addToCart(Request $request, $id = 'id') {
        $data = $request->all();
        $data = json_decode(json_encode($data));
        // dd($data);
        if(!$data) {
            abort(404);
        }

        // Get all cart items
        $cart = session()->get('cart') ? session()->get('cart') : [];

        // dd($cart);

        // Check if an item is already in the cart or not
        // Loop to check
        $cartCount = count($cart);
        $cartKeyMatch = null;

        // Return key
        foreach($cart as $key => $singleCartItem) {
            // Check if Ids match
            if($singleCartItem['id'] === $data->id) {
                // If they match, store the key value
                $cartKeyMatch = $key;
            }
        }
            
        // Proceed as normal
        $cart = $this->addCartItem($cart, $data);
        

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function addCartItem($cart = [], $newItemData = null) {
        // Add item
        // Calculate price
        $price = $newItemData->price ?? 0;

        $cartItem = [
            "id" => $newItemData->id,
            "product_name" => $newItemData->product_name,
            "quantity" => 1,
            "price" => $price
        ];

        // Use time as the cart Id since a cart can have 2 products with different sizes. They have to be treated as different products.
        $cart[time()] = $cartItem;

        // Return cart with new item innit
        return $cart;
    }

    public function updateCart(Request $request)
    {
        // Get input
        $quantity = $request->input('quantity');

        if($request->id){
            $cart = session()->get('cart');
            // dd($cart);
            if(isset($cart[$request->id])) {
                $cart[$request->id]['quantity'] = $quantity;
                // dd($cart);
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Product added to cart successfully!');
            }
        }
    }

    public function deleteCart(Request $request) {
        if($request->id) {
            $cart = session()->get('cart');

            if(isset($cart[$request->id])) {

                unset($cart[$request->id]);

                session()->put('cart', $cart);
            }
            return redirect()->back();
            session()->flash('success', 'Product removed successfully');
        }
    }



    public function search(Request $request) {

        $request->validate([
            'query' =>'required|min:3',
        ]);
        $query = $request->input('query');

                // one way of searching for a product
        $products = Product::where('product_name', 'like', "%$query%")
                        ->orwhere('description', 'like', "%$query%")->paginate(10);
        //different way using the searchable trait
        // $products = Product::search($query)->paginate(10);

        return view('search-results')->with(compact('products'));
    }
}
