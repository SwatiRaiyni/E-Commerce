<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\NewsletterSubscriptionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\RatingController;


use App\Http\Controllers\Admin\CMSController;
use App\Http\Controllers\indexController;
use App\Http\Controllers\StripeController;
use App\Models\Category;

$catUrl = Category::select('url','status')->where('status',1)->get()->pluck('url')->toArray();
foreach($catUrl as $url){
    Route::GET('/'.$url,'App\Http\Controllers\ProductsController@listing');
}
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



    Route::get('/',[indexController::class,'index']);
    Route::get('/product/{id}','App\Http\Controllers\ProductsController@productdetails');
    Route::post('/getproductprice','App\Http\Controllers\ProductsController@getproductprice');

    Route::post('/add-to-cart','App\Http\Controllers\ProductsController@addtocart');
    Route::get('/cart','App\Http\Controllers\ProductsController@cart');

    Route::post('/update-cart-item-qty','App\Http\Controllers\ProductsController@updatecartitemqty');
    Route::post('/delete-cart-item','App\Http\Controllers\ProductsController@deletecartitem');
    Route::post('/add-sub-email','App\Http\Controllers\indexController@addsubemail');

    Route::post('/add-rating','App\Http\Controllers\RatingController@addrating');

Route::group(['middleware' => 'disable_back_btn'], function () {
Route::middleware('auth')->group(function () {
Route::middleware('is_user')->group(function () {

    Route::match(['get','post'],'/account','App\Http\Controllers\UserManagementController@myaccount');
    Route::post('/changepassworduser','App\Http\Controllers\UserManagementController@updatepassword');
    Route::match(['get','post'],'/checkout','App\Http\Controllers\OrdersController@checkout');
    Route::match(['get','post'],'/add-edit-delivery-address/{id?}','App\Http\Controllers\OrdersController@addeditdeliveryaddress');
    Route::get('/delete-delivery-address/{id}','App\Http\Controllers\OrdersController@deletedeliveryaddress');
    Route::get('/ordersuccess','App\Http\Controllers\OrdersController@ordersuccess');//for cod
    Route::get('/paypal','App\Http\Controllers\PaypalController@paypal');
    Route::get('/myorders','App\Http\Controllers\OrdersController@myorder');
    Route::get('/orders/{id}','App\Http\Controllers\OrdersController@orderdetails');
    Route::match(['get','post'],'/orders/cancel/{id}','App\Http\Controllers\OrdersController@cancelorder');
    Route::match(['get','post'],'/orders/return/{id}','App\Http\Controllers\OrdersController@returnorder');
    Route::post('/getproductsize','App\Http\Controllers\OrdersController@getproductsize');
    Route::get('/paypal/success','App\Http\Controllers\PaypalController@paypalsuccess');//for paypal success
    Route::get('sendSMS', 'App\Http\Controllers\PaypalController@sendsms');

    Route::get('/paypal/fail','App\Http\Controllers\PaypalController@paypalfail');//for paypal fail
    Route::any('/paypal/ipn','App\Http\Controllers\PaypalController@paypalipn');//for paypal notify

    Route::get('/subscription','App\Http\Controllers\SubscriptionController@subscription');
    Route::get('/subscription1','App\Http\Controllers\SubscriptionController@subscription1');
    Route::get('/subscription11','App\Http\Controllers\SubscriptionController@subscription11');
    Route::get('/paypal/subscriptionsuccess','App\Http\Controllers\SubscriptionController@subscriptionsuccess');//for paypal success
    Route::any('/paypal/ipn1','App\Http\Controllers\PaypalController@paypalipn1');//for paypal notify



    Route::get('/stripe-payment', [StripeController::class, 'handleGet']);
    Route::post('/stripe-payment', [StripeController::class, 'handlePost'])->name('stripe.payment');

    Route::get('/accesstoken','App\Http\Controllers\PaypalController@gettoken');
    Route::get('/product','App\Http\Controllers\PaypalController@product');
    Route::get('/plan','App\Http\Controllers\PaypalController@plan');
    Route::get('/subscriptionapi','App\Http\Controllers\PaypalController@subscription');
    Route::get('/suspend','App\Http\Controllers\PaypalController@suspend');
    Route::any('/cancelsub/{id}','App\Http\Controllers\PaypalController@cancelsub');
    Route::any('/changesub/{id}','App\Http\Controllers\PaypalController@changesub');
    Route::any('/changesubnew/{id}/{pid}','App\Http\Controllers\PaypalController@changesubnew');

    Route::get('/subscriptionnew','App\Http\Controllers\PaypalController@newsub');
    Route::post('/savedata','App\Http\Controllers\PaypalController@savedata');
    Route::post('/changedata','App\Http\Controllers\PaypalController@changedata');
    Route::get('/listsub','App\Http\Controllers\PaypalController@listsub');
});
});



// Route::get('/dashboard', function () {
//     return view('fronted.dashboard');
// })->middleware(['auth'])->name('dashboard');
//for front user



//for backend user
Route::middleware('auth:admin')->group(function () {
Route::middleware('is_admin')->group(function () {
Route::prefix('/admin')->namespace('Admin')->group(function(){
    Route::get('dashboard',[UserManagementController::class,'indexnew']);
    Route::get('settings',[UserManagementController::class,'setting'])->name('settings');
    Route::POST('changepassword',[UserManagementController::class,'changepass']);
    Route::GET('/usermangement',[UserManagementController::class,'index']);
    Route::GET('/edituser/{id}',[UserManagementController::class,'edituser'])->name('edituser');
    Route::GET('/addnewuser',[UserManagementController::class,'add'])->name('adduser');
    Route::post('/createnewuser',[UserManagementController::class,'createnewuser'])->name('createnewuser');
    Route::POST('/edituser',[UserManagementController::class,'update'])->name('edituser');
    Route::GET('/deleteuser/{id}',[UserManagementController::class,'delete'])->name('deleteuser');

    Route::GET('/view-user-charts',[UserManagementController::class,'viewuserchart'])->name('viewuserchart');

    Route::get('section',[SectionController::class,'section']);
    Route::POST('updatestatus',[SectionController::class,'updatesection']);
    Route::get('categories',[CategoryController::class,'categories']);
    Route::POST('updatecategory',[CategoryController::class,'updatecategory']);
    Route::match(['get','post'],'add-edit-category/{id?}',[CategoryController::class,'addeditcategory']);
    Route::post('append-categorylevel',[CategoryController::class,'appendcategorylevel']);
    Route::get('delete-category/{id}',[CategoryController::class,'deletecategory']);

    Route::get('products',[ProductsController::class,'products']);
    Route::POST('updateproduct',[ProductsController::class,'updateproduct']);
    Route::get('delete-product/{id}',[ProductsController::class,'deleteproduct']);
    Route::match(['get','post'],'add-edit-product/{id?}',[ProductsController::class,'addeditproduct']);

    Route::match(['get','post'],'add-attributes/{id}',[ProductsController::class,'addattribute']);
    Route::post('edit-attriute/{id}',[ProductsController::class,'editattribute']);
    Route::POST('updateattribute',[ProductsController::class,'updateattributestatus']);
    Route::get('delete-attribute/{id}',[ProductsController::class,'deleteattribute']);

    Route::get('cmsmanagement',[CMSController::class,'cmsmanagement']);
    Route::POST('updatecms',[CMSController::class,'updatecmsstatus']);
    Route::get('delete-banner/{id}',[CMSController::class,'deletecms']);
    Route::match(['get','post'],'add-edit-cms/{id?}',[CMSController::class,'addeditcms']);

    Route::get('/orders',[OrdersController::class,'orders']);
    Route::get('/orders/{id}',[OrdersController::class,'orderdetails']);
    Route::get('/subscription',[OrdersController::class,'subscription']);
    Route::post('/update-order-status',[OrdersController::class,'updateorderstatus']);
    Route::get('/view-order-invoice/{id}',[OrdersController::class,'viewOrdersInvoice']);
    Route::get('/print-pdf-invoice/{id}',[OrdersController::class,'printPDFInvoice']);
    Route::get('/view-subscribe-invoice/{id}',[OrdersController::class,'viewSubscriptionInvoice']);
    Route::GET('/view-orders-charts',[OrdersController::class,'vieworderchart'])->name('vieworderchart');

    Route::get('/subscribeemail',[NewsletterSubscriptionController::class,'newsletterSubscription']);
    Route::POST('updateemailsub',[NewsletterSubscriptionController::class,'updateemailsub']);
    Route::get('delete-subscriber/{id}',[NewsletterSubscriptionController::class,'deletesubscriber']);

    Route::get('/rating',[RatingController::class,'rating']);
    Route::POST('/updaterating',[RatingController::class,'updaterating']);

    Route::get('/returnrequest',[OrdersController::class,'returnrequest']);
    Route::get('/exchagerequest',[OrdersController::class,'exchangerequest']);
    Route::post('/return-request/update',[OrdersController::class,'returnrequestupdate']);
    Route::post('/exchange-request/update',[OrdersController::class,'exchangerequestupdate']);

});
});
});
});

Route::prefix('admin')->group(function () {//prefix routing
Route::name('admin.')->group(function () {//naming routing

    Route::middleware('guest:admin')->group(function () {//group middleware
        Route::get('/login','App\Http\Controllers\Admin\Auth\AuthenticatedSessionController@create')->name('login');
        Route::POST('/adminlogin','App\Http\Controllers\Admin\Auth\AuthenticatedSessionController@store')->name('adminlogin');
    });
    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', 'App\Http\Controllers\Admin\Auth\AuthenticatedSessionController@destroy')->name('logout');
    });

});
});


require __DIR__.'/auth.php';
