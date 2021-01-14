<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Image;
use Auth;
use Session;
use App\Cart;
use App\Category;
use App\Products_Attributes;
use App\SliderProducts;
use App\Accompaniment;
use App\Product;
use App\Products_Images;
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
            if($request->hasFile('image')) {
                //get filename with extension
                $filenamewithextension = $request->file('image')->getClientOriginalName();

                //get filename without extension
                $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

                //get file extension
                $extension = $request->file('image')->getClientOriginalExtension();

                //filename to store
                $filenametostore = $filename.'_'.time().'.'.$extension;

                //Upload File
                $request->file('image')->storeAs('public/products/medium', $filenametostore);
                $request->file('image')->storeAs('public/products/small', $filenametostore);

                //Resize image here
                $medium_image_path = public_path('storage/products/medium/'.$filenametostore);
                $small_image_path = public_path('storage/products/small/'.$filenametostore);
                Image::make($medium_image_path)->resize(700,210)->save($medium_image_path);
                Image::make($small_image_path)->resize(436,354)->save($small_image_path);
                // Store image name in products table
                $product->image = $filenametostore;

            }
                //echo "<pre>";print_r($product);die;
                $product->save();
                return redirect()->back()->with('flash_message_success','Product Added Successfuly!');

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
            //Upload Image
            if($request->hasFile('image')) {
                //get filename with extension
                $filenamewithextension = $request->file('image')->getClientOriginalName();

                //get filename without extension
                $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

                //get file extension
                $extension = $request->file('image')->getClientOriginalExtension();

                //filename to store
                $filenametostore = $filename.'_'.time().'.'.$extension;

                //Upload File
                $request->file('image')->storeAs('public/products/medium', $filenametostore);
                $request->file('image')->storeAs('public/products/small', $filenametostore);

                //Resize image here
                $medium_image_path = public_path('storage/products/medium/'.$filenametostore);
                $small_image_path = public_path('storage/products/small/'.$filenametostore);
                Image::make($medium_image_path)->resize(700,210)->save($medium_image_path);
                Image::make($small_image_path)->resize(436,354)->save($small_image_path);

            }else{
                $filenametostore = $data['current_image'];
            }

            if (empty($data['description'])) {
                $data['description'];
            }
            Product::where(['id'=>$id])->update(['category_id'=>$data['category_id'],'product_name'=>$data['product_name'],'product_code'=>$data['product_code'],'description'=>$data['description'],'price'=>$data['price'],'image'=>$filenametostore]);

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

    public function addAttributes(Request $request, $id=null ) {
        $productDetails = Product::with('attributes')->where(['id'=>$id])->first();
        //echo "<pre>"; print_r($productDetails);die;
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data);die;
            foreach ($data['accompaniment'] as $key => $val) {

                    $attribute = new Products_Attributes;
                    $attribute->product_id = $id;
                    $attribute->category_id = $data['category_id'];
                    $attribute->accompaniment = $val;
                    $attribute->size =$data['size'][$key] ;
                    $attribute->price = $data['price'][$key];
                    //echo "<pre>";print_r($attribute);die;
                    $attribute->save();

            }

            return redirect('admin/add_attributes/'.$id)->with('flash_message_success', 'Product Attributes have been updated Successfully!');
        }
        return view('admin/products.add_attributes')->with(compact('productDetails'));
    }
    public function editAttributes(Request $request, $id=null) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";print_r($data);die;
            foreach ($data['idAttr'] as $key => $attr) {
                Products_Attributes::where(['id'=>$data['idAttr'][$key]])->update(['price'=>$data['price'][$key]]);
            }
            return redirect()->back()->with('flash_message_success', 'Price updated Successfuly!');
        }
    }

    public function deleteAttribute($id = null) {
        Products_Attributes::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success','Attribute has been Deleted Successfully!');
    }

    public function addAccompaniment(Request $request, $id=null ) {
        $productDetails = Product::with('accompaniments')->where(['id'=>$id])->first();
        //echo "<pre>"; print_r($productDetails);die;

        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data);die;
            foreach ($data['accompaniment'] as $key => $val) {
                if (!empty($val)) {
                    $accompaniments = new Products_Attributes;
                    $accompaniments->product_id = $id;
                    $accompaniments->accompaniment = $data['accompaniment'][$key];
                    //echo "<pre>";print_r($accompaniments);die;
                    $accompaniments->save();
                }
            }

            return redirect('admin/add_accompaniments/'.$id)->with('flash_message_success', 'Accompaniment have been updated Successfully!');
        }
        return view('admin/products.add_accompaniment')->with(compact('productDetails'));
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
    public function deleteAccompaniment($id = null) {
        Accompaniment::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success','Accompaniment has been Deleted Successfully!');
    }

    public function deleteProduct($id = null) {
        Product::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success','Product has been Deleted Successfully!');
    }

    public function deleteSliderProduct($id = null) {
        SliderProducts::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success','Product has been Deleted Successfully!');
    }

    public function deleteProductImage($id) {

        // Get Product Image
        $productImage = Product::where('id',$id)->first();

        // Get Product Image Paths#
        $orginal_image =  'storage/products/';
        $medium_image_path = 'storage/products/medium/';
        $small_image_path = 'storage/products/small/';

        // Delete Large Image if not exists in Folder
        if(file_exists($orginal_image.$productImage->image)){
            unlink($orginal_image.$productImage->image);
        }
        // Delete Medium Image if not exists in Folder
        if(file_exists($medium_image_path.$productImage->image)){
            @unlink($medium_image_path.$productImage->image);
        }

        // Delete Small Image if not exists in Folder
        if(file_exists($small_image_path.$productImage->image)){
            @unlink($small_image_path.$productImage->image);
        }

        // Delete Image from Products table
        Product::where(['id'=>$id])->update(['image'=>'']);

        return redirect()->back()->with('flash_message_success', 'Product image has been deleted successfully');
    }


    public function products($id = null,$category_id='category_id') {

        //get main categories
        $mainCategories = Category::where(['parent_id'=>0])->get();

        //get sub categories
        $subCategories = Category::where(['parent_id' => $id])->get();
        //dd($subCategories);

        $allDetails = [];

        foreach ($subCategories as $subCategory) {
            $getCatNames = Category::with('products.attributes')->where(['id' =>$subCategory->id])->get();
            $getCatNames = json_decode(json_encode($getCatNames));
            //dd($getCatNames);
            array_push($allDetails, $getCatNames);

        }
        $checkProduct = Products_Attributes::get();
        //dd($checkProduct);
            // dd($allDetails);

        return view('frontpages/menu-list-collapse')->with(compact('mainCategories','allDetails','checkProduct'));
    }

    public function singleProduct($id = null, $category_id='category_id'){

        //get sub categories
        $subCategories = Category::where(['parent_id' => $id])->get();
        //dd($subCategories);

        $allDetails = [];

        foreach ($subCategories as $subCategory) {

            $getCatNames = Category::with('products.attributes')->where(['id' =>$subCategory->id])->get();
            $getCatNames = json_decode(json_encode($getCatNames));
            //dd($getCatNames);
            array_push($allDetails, $getCatNames);

        }
            //dd($allSpecificDetails);
        return view('frontpages/menu-single')->with(compact('subCategories','allDetails'));
    }

    public function getProductPrice(Request $request){
        $data = $request->all();
        //echo "<pre>";print_r($data);die;
        // $proArr = explode("-",$data['idSize']);
        //echo "<pre>";print_r($proArr);die;
        $proAttr = Products_Attributes::where(['id' => $data['idSize']])->get();

        return $proAttr[0] ? $proAttr[0] : null;
        // foreach ($proAttr as $pesa) {
        //    return $pesa->price;
        // }
        //dd($proAttr);
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

        // Use the size Id to get size information, if any
        if($data->size) {
            $sizeDetails = Products_Attributes::where(['id' => $data->size])->get();
        } else if($data->accompaniment) {
            $sizeDetails = Products_Attributes::where(['id' => $data->accompaniment])->get();
        } else {
            $sizeDetails = null;
        }
        // dd($sizeDetails);

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

        if($cartKeyMatch) {
            // Check if accompaniments match
            if($cart[$cartKeyMatch]['accompaniment_id'] === $data->size) {
                // Edit particular entry by adding qty
                $cart[$cartKeyMatch]['quantity']++;

            } else {
                // Treat as a different product, proceed as normal
                $cart = $this->addCartItem($cart, $data, $sizeDetails);
            }

        } else {
            // Proceed as normal
            $cart = $this->addCartItem($cart, $data, $sizeDetails);
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function addCartItem($cart = [], $newItemData = null, $sizeDetails = null) {
        // Add item
        // Calculate price
        $price = $newItemData->price ?? 0;

        if($sizeDetails && count($sizeDetails) > 0) {
            // 1. Check if it is a size
            if($sizeDetails[0]->size) {
                $price = $sizeDetails[0]->price;
            } else {
                // 2. Check whether it is a priced accompaniment
                if($sizeDetails[0]->price) {
                    $price = $price + $sizeDetails[0]->price;
                }
            }
        }

        $cartItem = [
            "id" => $newItemData->id,
            "product_name" => $newItemData->product_name,
            "quantity" => 1,
            "price" => $price,
            "accompaniment_id" => $sizeDetails && $sizeDetails[0]->id ? $sizeDetails[0]->id : null,
            "accompaniment_price" => $sizeDetails && $sizeDetails[0]->price ? $sizeDetails[0]->price : null,
            "accompaniment_size" => $sizeDetails && $sizeDetails[0]->size ? $sizeDetails[0]->size : null,
            "accompaniment" => $sizeDetails && $sizeDetails[0]->accompaniment ? $sizeDetails[0]->accompaniment : null
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
