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


// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@Index')->middleware('verified');


Route::get('/','PagesController@Index');
Route::match(['get','post'], 'page-contact', 'PagesController@Contact');
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


Route::get('/logout', 'AdminController@logout');



