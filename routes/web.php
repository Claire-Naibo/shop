<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

/**Client Side Routes */

//Homepage Routes
Route::get('/','PagesController@Index');
Route::get('/home', 'HomeController@Index');

//Get Menu Categories & Products
Route::match(['get','post'], '/menu-list-navigation','ProductsController@products');

//add to cart route
Route::match(['get','post'],'add-to-cart/{id}', 'ProductsController@addToCart');
Route::match(['get','post'],'/cart/update-cart/{id}', 'ProductsController@updateCart');
Route::match(['get','post'],'/cart/delete_cart/{id}','ProductsController@deleteCart');

//Checkout Page Route
Route::match(['get','post'], '/checkout','CheckoutController@guestCheckout');
Route::get('/guest-checkout','CheckoutController@guestCheckout');
Route::match(['get','post'], '/user-checkout','CheckoutController@Checkout')->middleware('auth');

//billing info route
Route::match(['get','post'],'/billing', 'CheckoutController@storeOrder');
Route::match(['get', 'post'], '/payments', 'PaymentsController@viewPayments');
Route::match(['get', 'post'], '/payments/process', 'PaymentsController@processPayments');
Route::get('/mailable', function() {
	$order = App\Order::find(3);

	return new App\Mail\OrderPlaced($order);
});

//Register & Login Routes
Route::match(['get','post'], '/user-register', 'UserController@Register');
Route::match(['get','post'], '/user-login','UserController@Login');

//User Account Route with middleware
Route::group(['middleware'=>['Frontlogin','verified']], function() {
	
	Route::match(['get','post'], '/account', 'UserController@Account');
	Route::match(['get','post'], '/loginpage', 'UserController@loginPage');

	//order List
	Route::match(['get','post'],'/order-details','UserController@getOrders');
	//check current password	
	Route::post('/check-user-pwd','UserController@CheckUserPwd');
	//Update current password in db
	Route::post('/update-user-pwd', 'UserController@updateUserPassword');

});

//User's logout
Route::get('/user-logout','UserController@logout');

/** Client Routes End */

//admin login route
Route::match(['get', 'post'],'/admin', 'AdminController@login');

//Admin Routes
Route::get('/admin/dashboard', 'AdminController@dashboard');
Route::get('/admin/settings','AdminController@settings');
Route::get('/admin/check-pwd','AdminController@chkPassword');
Route::match(['get','post'],'/admin/update-pwd','AdminController@updatePassword');

//view users from admin
Route::match(['get','post'],'/admin/edit_user/{id}','AdminController@editUser');
Route::get('/admin/users/view_users','AdminController@viewUsers');
Route::match(['get','post'],'/admin/delete_user/{id}','AdminController@deleteUser');


//Categories Routes (Admin)
Route::match(['get','post'],'/admin/categories/add_category','CategoryController@addCategory');
Route::match(['get','post'],'/admin/edit_category/{id}','CategoryController@editCategory');
Route::get('/admin/categories/view_category','CategoryController@viewCategories');
Route::match(['get','post'],'/admin/delete_category/{id}','CategoryController@deleteCategory');
Route::get('/admin/delete_category_image/{id}', 'CategoryController@deleteCategoryImage');

//Products route
Route::match(['get','post'],'/admin/add_products','ProductsController@addProduct');
Route::match(['get','post'],'/admin/edit_product/{id}','ProductsController@editProduct');
Route::get('/admin/products/view_products','ProductsController@viewProducts');
Route::get('/admin/delete_product/{id}','ProductsController@deleteProduct');


//Manage Orders Route in Admin
Route::post('toggledeliver/{orderId}', 'OrderController@toggledeliver')->name('toggle.deliver');
Route::get('orders/{type?}','OrderController@Orders');
Route::match(['get','post'],'/admin/delete_order/{id}','OrderController@deleteOrder');
Route::match(['get','post'],'/admin/edit_order/{id}','OrderController@editOrder');

//routes to view orders from the dashboard
Route::get('/admin/orders/view_orders','PagesController@viewOrders');
Route::get('/admin/orders/pending_orders','PagesController@pendingOrders');

Route::get('/logout', 'AdminController@logout');

/** Admin Routes End*/





