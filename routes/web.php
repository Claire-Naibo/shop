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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes(['verify' => true]);

//user email activation
Route::get('/user/activation/{token}', 'Auth\RegisterController@userActivation');

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'PagesController@Index')->middleware('verified');


Route::get('/','PagesController@Index');
Route::match(['get','post'], 'page-contact', 'PagesController@Contact');
//admin login route
Route::match(['get', 'post'],'/admin', 'AdminController@login');

//Admin Routes
Route::get('/admin/dashboard', 'AdminController@dashboard');
Route::get('/admin/settings','AdminController@settings');
Route::get('/admin/check-pwd','AdminController@chkPassword');
Route::match(['get','post'],'/admin/update-pwd','AdminController@updatePassword');

//Categories Routes (Admin)
Route::match(['get','post'],'/admin/categories/add_category','CategoryController@addCategory');
Route::match(['get','post'],'/admin/edit_category/{id}','CategoryController@editCategory');
Route::get('/admin/categories/view_category','CategoryController@viewCategories');
Route::match(['get','post'],'/admin/delete_category/{id}','CategoryController@deleteCategory');

//Products route
Route::match(['get','post'],'/admin/add_products','ProductsController@addProduct');
Route::match(['get','post'],'/admin/edit_product/{id}','ProductsController@editProduct');
Route::get('/admin/products/view_products','ProductsController@viewProducts');
Route::get('/admin/delete_product/{id}','ProductsController@deleteProduct');
Route::get('/admin/delete_product_image/{id}', 'ProductsController@deleteProductImage');
Route::get('/admin/delete_alt_image/{id}', 'ProductsController@deleteAltImage');


//Manage Orders Route in Admin
Route::post('toggledeliver/{orderId}', 'OrderController@toggledeliver')->name('toggle.deliver');
Route::get('orders/{type?}','OrderController@Orders');
Route::match(['get','post'],'/admin/delete_order/{id}','OrderController@deleteOrder');
Route::match(['get','post'],'/admin/edit_order/{id}','OrderController@editOrder');

//routes to view orders from the dashboard
Route::get('/admin/orders/view_orders','PagesController@viewOrders');
Route::get('/admin/orders/pending_orders','PagesController@pendingOrders');

Route::get('/logout', 'AdminController@logout');



