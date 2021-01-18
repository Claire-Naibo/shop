<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlaced;
use App\Models\OrderProduct;
use App\Models\User;
use App\Models\Order;
use App\Models\Cart;
use Auth;
use Session;
use DB;

class CheckoutController extends Controller
{
    public function guestCheckout(Request $request, $id=null){
        $userDetails = User::first();
        //echo "<pre>";print_r($userDetails);die;

        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>";print_r($data);die;

            $user = User::find($user_id);
            $user->name = $data['name'];
            $user->mobile = $data['mobile'];
            $user->email = $data['email'];
            $user->address = $data['address'];
            $user->city = $data['city'];
            $user->country_code = $data['country_code'];
            $user->save();

            return redirect()->back()->with('flash_message_success','Your Account Details have been Updated Succesfully');
		}

        $cart = session()->get('cart');

        return view('checkout')->with(compact('userDetails', 'cart'));
	}

    public function Checkout(Request $request, $session_id = null) {

        $cart = session()->get('cart');

        return view('checkout');
	}

	 //create a charge but for now its cash on delivery
    public function storeOrder(Request $request) {
        $data = $request->all();

        $order = $this->addToOrdersTables($request, null);

        // Store user data in session
        $user_details = [
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'country_code' => $request->country_code,
        ];

        session(['user_details' => $user_details]);

         return view('confirmation');
    }

    protected function addToOrdersTables($request, $error, $session_id = null) {
        // Insert into orders table
        $carts = session()->get('cart');
        $carts = json_decode(json_encode($carts));
		//dd($carts);
		$order = Order::create([
			'user_id' => auth()->user() ? auth()->user()->id : null,
			'name' => $request->name,
			'email' => $request->email,
			'mobile' => $request->mobile,
			'address' => $request->address,
			'country_code' => $request->country_code,
			'total' => $request->total,
		]);

		// Store order details in session
		$order ? session(['orderDetails' => ['orderId' => $order->id]]) : '';

		// Insert into orderProiduct table
		foreach ($carts as $item) {
			OrderProduct::create([
				'order_id' => $order->id,
				'product_id' => $item->id,
				'quantity' => $item->quantity,
				'price' => $item->price,
			]);
		}

		return $order;
	}
}
