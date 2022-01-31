<?php

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Mail\WelcomeMail;
use App\Mail\OrderNotifyToAdminMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


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


Route::get('/fire', function () {
    event(new \App\Events\TestEvent());
    return 'ok';
});



Route::get('/test-email', function () {


    try {

        $myEmail = 'asifulhaque087@gmail.com';

        $details = [
            'title' => 'Mail Demo from ItSolutionStuff.com',
            'url' => 'https://www.itsolutionstuff.com'
        ];

        $url = "http://127.0.0.1:8000/private-panel/orders/detail/932";

        Mail::to($myEmail)->send(new OrderNotifyToAdminMail($url));
        return "Basic Email Sent. Check your inbox.";

    } catch(Exception $e) {
        return 'Message: ' .$e->getMessage();
        
    }


    // try {
    //     $myEmail = 'asifulhaque087@gmail.com';
    //     $details = [
    //         'title' => 'Mail Demo from ItSolutionStuff.com',
    //         'url' => 'https://www.itsolutionstuff.com'
    //     ];

    //     // Mail::to($myEmail)->send(new MyDemoMail($details));
    //     Mail::to($myEmail)->send(new WelcomeMail($details));
    //     // echo "Basic Email Sent. Check your inbox.";
    //     return "Basic Email Sent. Check your inbox.";
    //     // return "hello";

    // } catch(Exception $e) {
    //     // echo 'Message: ' .$e->getMessage();
    //     return 'Message: ' .$e->getMessage();
        
    // }

});

Route::get('/test-sms',function(){
//  139.59.13.75
//  10.122.0.2
    // $url = "http://66.45.237.70/api.php";
    // $number="01906489959";
    // $text="Hello Bangladesh";
    // $data= array(
    // 'username'=>"Tanvir98",
    // 'password'=>"TAMCND8V",
    // 'number'=>"$number",
    // 'message'=>"$text"
    // );

    // $ch = curl_init(); // Initialize cURL
    // curl_setopt($ch, CURLOPT_URL,$url);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // $smsresult = curl_exec($ch);
    // $p = explode("|",$smsresult);
    // $sendstatus = $p[0];

    // return $sendstatus;

    $url = 'https://otpsmsbd.com/api/bulkSmsApi';

    $mobileNumber = "01903709156";
    $message = "BS2938";

    $data = array(
    'sender_id' => env('SMS_SENDER_ID'),
    'apiKey' => env('SMS_SENDER_API_KEY'),
    'mobileNo' => $mobileNumber,
    'message' => $message,
    );

    try {

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);     
        $output = curl_exec($curl);
        curl_close($curl);
        return true;

    } catch (\Throwable $th) {
        Log::error('Error sending message using gateway.');
        return false;
    }


});


Route::view('ge','test');
Route::view('test','doc.index');


Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('view:clear');
    return redirect()->back();
});
Route::get('/', function () {
    // return "hello";
    return view('auth.login');
})->middleware('guest');


Route::get('/email', function () {

    $notifications = Notification::where('notifiable_type', User::class)->get();

});

Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');





Route::get('/admin-login', function () {
    return view('auth.admin-login');
});

Route::get('/logout', ['uses' => 'Auth\LoginController@logout', 'as' => 'logout']);



Route::group(['prefix' => 'private-panel', 'middleware' => ['auth']], function () {
    Route::get('/dashboard', ['uses' => 'Admin\DashboardController@Index'])->name('dashboard'); // route name already used
    Route::get('/dashboard/filter/salesByDateRange', ['uses' => 'Admin\DashboardController@filterSalesByDate'])->name('dashboard.filterSalesByDate'); // route name already used

    // Route::get('/invoice', 'Admin\InvoiceController@invoice')->name('invoice');
    Route::get('/invoice', 'Admin\InvoiceController@inv')->name('invoice');
    Route::get('/order/show', function () {
        return view('admin.Orders.show');
    });

    Route::get('wallets/{wallet}', 'Admin\WalletController@show')->name('wallet.show');
    Route::get('wallets', 'Admin\WalletController@index')->name('wallet.index');


    Route::group(['prefix' => 'orders'], function () {
        Route::get('/refund', ['uses' => 'Admin\OrderItemController@Refund', 'as' => 'order.refund']);
        Route::get('remove-items/{id}', ['uses' => 'Admin\OrderItemController@RemoveItem', 'as' => 'order.removeItem']);
        Route::get('delete/{id}', ['uses' => 'Admin\OrderController@destroy', 'as' => 'order.delete']);
        Route::get('invoice/{id}', ['uses' => 'Admin\OrderController@invoice', 'as' => 'order.invoice']);
        Route::post('add-items/{id}', ['uses' => 'Admin\OrderItemController@AddItem', 'as' => 'order.addItem']);
        Route::get('monthly-order-graph', 'Admin\OrderReportController@MonthlyOrderReportGraph')->name('monthlyOrderGraph');
        Route::get('yearly-order-graph', 'Admin\OrderReportController@YearlyOrderReportGraph')->name('yearlyOrderGraph');
        Route::get('daily-order-graph', 'Admin\OrderReportController@DailyOrderReportGraph')->name('dailyOrderGraph');
        Route::get('delivered_orders', 'Admin\OrderController@GetDeliveredOrders')->name('deliveredOrdersIndex');
        Route::get('undelivered_orders', 'Admin\OrderController@GetUnDeliveredOrders')->name('unDeliveredOrdersIndex');
        Route::get('list-ssl-ipn-response', 'Admin\OrderController@SSLResponseIndex')->name('sslIpnResposne');

        Route::get('index', ['uses' => 'Admin\OrderController@index', 'as' => 'order.index']);
        Route::get('detail/{id}', ['uses' => 'Admin\OrderController@Detail', 'as' => 'order.detail']);
        Route::post('add-discount', ['uses' => 'Admin\OrderController@Discount', 'as' => 'order.discount']);
        Route::get('change-status', ['uses' => 'Admin\OrderStatusController@ChangeStatus', 'as' => 'order.changeStatus']);
        Route::get('export-daily-orders', ['uses' => 'Admin\OrderController@ExportDailyOrders', 'as' => 'order.ExportDailyOrders']);

        Route::post('date-range/index', ['uses' => 'Admin\OrderController@getDateFilteredOrder', 'as' => 'order.getDateFilteredOrder']);
    });

    Route::group(['prefix' => 'sliders'], function () {
        Route::get('index', ['uses' => 'Admin\SliderController@Index', 'as' => 'slider.index']);
        Route::get('create', ['uses' => 'Admin\SliderController@Create', 'as' => 'slider.create']);
        Route::get('edit/{id}', ['uses' => 'Admin\SliderController@Edit', 'as' => 'slider.edit']);
        Route::post('store', ['uses' => 'Admin\SliderController@Store', 'as' => 'slider.store']);
        Route::post('update/{id}', ['uses' => 'Admin\SliderController@Update', 'as' => 'slider.update']);
        Route::get('delete/{id}', ['uses' => 'Admin\SliderController@Delete', 'as' => 'slider.delete']);
    });
    Route::group(['prefix' => 'categories'], function () {
        Route::get('index', ['uses' => 'Admin\CategoryController@Index', 'as' => 'category.index']);
        Route::get('create', ['uses' => 'Admin\CategoryController@Create', 'as' => 'category.create']);
        Route::get('edit/{id}', ['uses' => 'Admin\CategoryController@Edit', 'as' => 'category.edit']);
        Route::post('store', ['uses' => 'Admin\CategoryController@Store', 'as' => 'category.store']);
        Route::post('update/{id}', ['uses' => 'Admin\CategoryController@Update', 'as' => 'category.update']);
        Route::get('delete/{id}', ['uses' => 'Admin\CategoryController@Delete', 'as' => 'category.delete']);

        Route::post('update-order','Admin\CategoryController@UpdateOrder');
    });
    Route::group(['prefix' => 'brands'], function () {
        Route::get('index', ['uses' => 'Admin\BrandController@Index', 'as' => 'brand.index']);
        Route::get('create', ['uses' => 'Admin\BrandController@Create', 'as' => 'brand.create']);
        Route::get('edit/{id}', ['uses' => 'Admin\BrandController@Edit', 'as' => 'brand.edit']);
        Route::post('store', ['uses' => 'Admin\BrandController@Store', 'as' => 'brand.store']);
        Route::post('update/{id}', ['uses' => 'Admin\BrandController@Update', 'as' => 'brand.update']);
        Route::get('delete/{id}', ['uses' => 'Admin\BrandController@Delete', 'as' => 'brand.delete']);

        Route::post('update-order','Admin\BrandController@UpdateOrder');
    });
    Route::group(['prefix' => 'products'], function () {
        Route::get('index', ['uses' => 'Admin\ProductController@index', 'as' => 'product.index']);
        Route::get('slug-update', ['uses' => 'Admin\ProductController@SlugUpdate', 'as' => 'product.slug_update']);
        Route::get('create', ['uses' => 'Admin\ProductController@create', 'as' => 'product.create']);
        Route::get('edit/{id}', ['uses' => 'Admin\ProductController@edit', 'as' => 'product.edit']);
        Route::post('store', ['uses' => 'Admin\ProductController@store', 'as' => 'product.store']);
        Route::post('update/{id}', ['uses' => 'Admin\ProductController@update', 'as' => 'product.update']);
        Route::get('delete/{id}', ['uses' => 'Admin\ProductController@delete', 'as' => 'product.delete']);
        Route::get('restore/{id}', ['uses' => 'Admin\ProductController@restore', 'as' => 'product.restore']);
        Route::get('featured/{id}', ['uses' => 'Admin\ProductController@featured', 'as' => 'product.featured']);

        Route::get('deleted', ['uses' => 'Admin\ProductController@DeletedProducts', 'as' => 'product.deleted']);

        Route::get("bundle/list", 'Admin\BundleProductController@BundleProductsList')->name('product.bundleList');
        Route::get("bundle/{product}/makeBundle", 'Admin\BundleProductController@MakeBundle')->name('product.makeBundle');
        Route::post("bundle/{product}/syncBundle", 'Admin\BundleProductController@SyncBundleProducts')->name('product.syncBundle');
        Route::get("bundle/{product}", 'Admin\BundleProductController@BundleProducts')->name('product.bundleProducts');
        Route::patch("bundle/{bundle}", 'Admin\BundleProductController@update')->name('bundle.update');

    });
    Route::group(['prefix' => 'product-images'], function () {
        Route::get('index/{id}', ['uses' => 'Admin\ProductImageController@index', 'as' => 'product_image.index']);
        Route::post('store', ['uses' => 'Admin\ProductImageController@store', 'as' => 'product_image.store']);
        Route::get('delete/{id}', ['uses' => 'Admin\ProductImageController@delete', 'as' => 'product_image.delete']);
    });
    Route::group(['prefix' => 'product-requests'], function () {
        Route::get('index/', ['uses' => 'Admin\ProductRequestController@index', 'as' => 'product_request.index']);
        Route::post('store', ['uses' => 'Admin\ProductRequestController@store', 'as' => 'product_request.store']);
        Route::get('delete/{id}', ['uses' => 'Admin\ProductRequestController@delete', 'as' => 'product_request.delete']);
    });
    Route::group(['prefix' => 'top-products'], function () {
        Route::get('index', ['uses' => 'Admin\TopProductController@index', 'as' => 'topProduct.index']);
        Route::get('edit/{id}', ['uses' => 'Admin\TopProductController@edit', 'as' => 'topProduct.edit']);
        Route::get('update', ['uses' => 'Admin\TopProductController@update', 'as' => 'topProduct.update']);
        Route::post('update/top-type-order', ['uses' => 'Admin\TopProductController@UpdateTopTypeOrder', 'as' => 'topProduct.updateTypeOrder']);
        Route::get('delete/{id}', ['uses' => 'Admin\TopProductController@delete', 'as' => 'topProduct.delete']);
    });


    Route::group(['prefix' => 'discounts'], function () {
        Route::get('index', ['uses' => 'Admin\DiscountController@index', 'as' => 'discount.index']);
        Route::get('create', ['uses' => 'Admin\DiscountController@create', 'as' => 'discount.create']);
        Route::get('edit/{id}', ['uses' => 'Admin\DiscountController@edit', 'as' => 'discount.edit']);
        Route::post('store', ['uses' => 'Admin\DiscountController@store', 'as' => 'discount.store']);
        Route::post('update', ['uses' => 'Admin\DiscountController@update', 'as' => 'discount.update']);
        Route::get('delete/{id}', ['uses' => 'Admin\DiscountController@delete', 'as' => 'discount.delete']);
    });

    Route::group(['prefix' => 'coupons'], function () {
        Route::get('index', ['uses' => 'Admin\CouponController@index', 'as' => 'coupon.index']);
        Route::get('create', ['uses' => 'Admin\CouponController@create', 'as' => 'coupon.create']);
        Route::get('edit/{id}', ['uses' => 'Admin\CouponController@edit', 'as' => 'coupon.edit']);
        Route::post('store', ['uses' => 'Admin\CouponController@store', 'as' => 'coupon.store']);
        Route::post('update', ['uses' => 'Admin\CouponController@update', 'as' => 'coupon.update']);
        Route::get('delete/{id}', ['uses' => 'Admin\CouponController@delete', 'as' => 'coupon.delete']);
    });
    Route::group(['prefix' => 'withdraws'], function () {
        Route::get('index', ['uses' => 'Admin\WithdrawController@index', 'as' => 'withdraw.index']);
        Route::get('create', ['uses' => 'Admin\WithdrawController@create', 'as' => 'withdraw.create']);
        Route::get('edit/{id}', ['uses' => 'Admin\WithdrawController@edit', 'as' => 'withdraw.edit']);
        Route::post('store', ['uses' => 'Admin\WithdrawController@store', 'as' => 'withdraw.store']);
        Route::post('update', ['uses' => 'Admin\WithdrawController@update', 'as' => 'withdraw.update']);
        Route::get('delete/{id}', ['uses' => 'Admin\WithdrawController@delete', 'as' => 'withdraw.delete']);
    });


    Route::group(['prefix' => 'offers'], function () {
        Route::get('index', ['uses' => 'Admin\OfferController@index', 'as' => 'offer.index']);
        Route::get('create', ['uses' => 'Admin\OfferController@create', 'as' => 'offer.create']);
        Route::get('edit', ['uses' => 'Admin\OfferController@edit', 'as' => 'offer.edit']);
        Route::post('store', ['uses' => 'Admin\OfferController@store', 'as' => 'offer.store']);
        Route::post('update', ['uses' => 'Admin\OfferController@update', 'as' => 'offer.update']);
        Route::get('delete', ['uses' => 'Admin\OfferController@delete', 'as' => 'offer.delete']);
    });
    Route::group(['prefix' => 'coupons'], function () {
        Route::get('index', ['uses' => 'Admin\CouponController@index', 'as' => 'coupon.index']);
        Route::get('create', ['uses' => 'Admin\CouponController@create', 'as' => 'coupon.create']);
        Route::get('edit/{id}', ['uses' => 'Admin\CouponController@edit', 'as' => 'coupon.edit']);
        Route::post('store', ['uses' => 'Admin\CouponController@store', 'as' => 'coupon.store']);
        Route::post('update', ['uses' => 'Admin\CouponController@update', 'as' => 'coupon.update']);
        Route::get('delete/{id}', ['uses' => 'Admin\CouponController@delete', 'as' => 'coupon.delete']);
    });
    Route::group(['prefix' => 'offers'], function () {
        Route::get('index', ['uses' => 'Admin\OfferController@index', 'as' => 'offer.index']);
        Route::get('create', ['uses' => 'Admin\OfferController@create', 'as' => 'offer.create']);
        Route::get('edit', ['uses' => 'Admin\OfferController@edit', 'as' => 'offer.edit']);
        Route::post('store', ['uses' => 'Admin\OfferController@store', 'as' => 'offer.store']);
        Route::post('update', ['uses' => 'Admin\OfferController@update', 'as' => 'offer.update']);
        Route::get('delete', ['uses' => 'Admin\OfferController@delete', 'as' => 'offer.delete']);
    });


    Route::resource('/role', 'Admin\\RoleController');

    Route::group(['prefix' => 'customer'], function(){
        Route::get('index', ['uses' => 'Admin\\CustomerController@index', 'as' => 'customer.index']);
        Route::post('index', ['uses' => 'Admin\\CustomerController@getDateFilteredCustomers', 'as' => 'customer.dateFiltered']);
        Route::delete('delete/{id}', ['uses' => 'Admin\\CustomerController@destroy', 'as' => 'customer.delete']);
        Route::get('assign_role/{customer}', 'Admin\\CustomerController@assign_role')->name('customer.assign_role');
        Route::patch('assign_role/{customer}', 'Admin\\CustomerController@sync_role')->name('customer.sync_role');
        Route::patch('disable_customer/{customer}', 'Admin\\CustomerController@disable_customer')->name('customer.disable_customer');
        Route::patch('enable_customer/{customer}', 'Admin\\CustomerController@enable_customer')->name('customer.enable_customer');
        Route::get('export', 'Admin\\CustomerController@export')->name('customer.export');

    });


    Route::group(['prefix' => 'delivery-charge'], function () {
        Route::get('index', ['uses' => 'Admin\DeliveryChargeController@index', 'as' => 'deliveryCharge.index']);
        Route::get('create', ['uses' => 'Admin\DeliveryChargeController@create', 'as' => 'deliveryCharge.create']);
        Route::get('edit/{id}', ['uses' => 'Admin\DeliveryChargeController@edit', 'as' => 'deliveryCharge.edit']);
        Route::post('store', ['uses' => 'Admin\DeliveryChargeController@store', 'as' => 'deliveryCharge.store']);
        Route::post('update', ['uses' => 'Admin\DeliveryChargeController@update', 'as' => 'deliveryCharge.update']);
        Route::get('delete/{id}', ['uses' => 'Admin\DeliveryChargeController@delete', 'as' => 'deliveryCharge.delete']);
    });

    Route::group(['prefix' => 'refunds'], function(){
        Route::get('index', ['uses' => 'Admin\RefundController@index', 'as' => 'refund.index']);
        Route::get('create', ['uses' => 'Admin\RefundController@create', 'as' => 'refund.create']);
        Route::get('edit/{id}', ['uses' => 'Admin\RefundController@edit', 'as' => 'refund.edit']);
        Route::post('store', ['uses' => 'Admin\RefundController@store', 'as' => 'refund.store']);
        Route::post('update', ['uses' => 'Admin\RefundController@update', 'as' => 'refund.update']);
        Route::get('delete/{id}', ['uses' => 'Admin\RefundController@delete', 'as' => 'refund.delete']);
        Route::get('change-status', ['uses' => 'Admin\RefundController@ChangeStatus', 'as' => 'refund.changeStatus']);
    });


    Route::group(['prefix' => 'pages'], function () {
        Route::get('index', ['uses' => 'Admin\PageController@Index', 'as' => 'page.index']);
        Route::get('create', ['uses' => 'Admin\PageController@Create', 'as' => 'page.create']);
        Route::get('edit/{id}', ['uses' => 'Admin\PageController@Edit', 'as' => 'page.edit']);
        Route::post('store', ['uses' => 'Admin\PageController@Store', 'as' => 'page.store']);
        Route::post('update/{id}', ['uses' => 'Admin\PageController@Update', 'as' => 'page.update']);
        Route::get('delete/{id}', ['uses' => 'Admin\PageController@Delete', 'as' => 'page.delete']);
    });

    Route::group(['prefix' => 'chats'], function () {
        Route::get('dashboard', ['uses' => 'Admin\ChatController@dashboard', 'as' => 'chats.dashboard']);
        Route::get('send_message/{guest_id}', ['uses' => 'Admin\ChatController@show', 'as' => 'chats.chat_room']);
        Route::post('send_message', ['uses' => 'Admin\ChatController@store', 'as' => 'chats.sendMessage']);
    });

    Route::resource('/employee', 'Admin\\EmployeeController');
    Route::get('/employee/assign_role/{user}', 'Admin\\EmployeeController@assign_role')->name('employee.assign_role');
    Route::patch('/employee/assign_role/{user}', 'Admin\\EmployeeController@sync_role')->name('employee.sync_role');


    Route::view('doc','doc.index')->middleware('role:admin');

});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
//Route::get('export', 'Admin\\CustomerController@export')->name('customer.export');
