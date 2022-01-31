<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});





/*
Route::get('all', 'TestController@all');
Route::get('get', 'TestController@get');
Route::get('all-user', 'TestController@allUser');
Route::get('all-user/get', 'TestController@allUserGet');
*/

Route::get('bkash', 'Api\V1\OrderController@bkash');
Route::post('/login', ['uses' => 'Api\V1\AuthController@Login']);
Route::post('/check-otp', ['uses' => 'Api\V1\AuthController@VerifyOTP']);
Route::post('/resend-otp', ['uses' => 'Api\V1\AuthController@resendOTP']);


Route::get('deletion/{provider}/{confirmation_code}/status', 'Auth\LoginController@DeletedFBUserStatus');
Route::post('deletion/{provider}/', 'Auth\LoginController@DeleteFacebookData');
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');



Route::post('/forget-password', ['uses' => 'Api\V1\AuthController@ForgetPassword']);
Route::post('/update-password', ['uses' => 'Api\V1\AuthController@ForgotPasswordChange']);
Route::post('/register', ['uses' => 'Api\V1\AuthController@Register']);
Route::post('/password-reset-token', ['uses' => 'Api\V1\AuthController@CreatePasswordResetToken']);
Route::get('/rating/get-top-rated-products', ['uses' => 'Api\V1\RatingController@getTopRatedProducts']);
Route::get('orders/get-order-by-unique-order-id/{uniqueOrderId}/{phone}', ['uses' => 'Api\V1\OrderController@getOrderDetailsOrderUniqueId']);

Route::group(['prefix' => 'sliders'], function () {
    Route::get('/', ['uses' => 'Api\V1\SliderController@GetSliders']);
});

Route::group(['prefix' => 'pages'], function () {
    Route::get('/', ['uses' => 'Api\V1\PageController@GetPages']);
    Route::get('/{slug}', ['uses' => 'Api\V1\PageController@SinglePage']);

});
Route::group(['prefix' => 'categories'], function () {
    Route::get('/', ['uses' => 'Api\V1\CategoryController@GetCategories']);
    // Route::get('/top-types',['uses'=>'Api\V1\CategoryController@TopTypes']);
    Route::get('/{slug}/products', ['uses' => 'Api\V1\CategoryController@GetProductsByCategory']);
});

Route::group(['prefix' => 'brands'], function () {
    Route::get('/', ['uses' => 'Api\V1\BrandController@GetBrands']);
    Route::get('/{slug}/products', ['uses' => 'Api\V1\BrandController@GetProductsByCategory']);

});

Route::get("bundle/get", 'Api\V1\BundleController@Bundles')->name('product.bundles');
Route::get("bundle/{product}", 'Api\V1\BundleController@BundleProducts')->name('product.bundleProducts');


Route::group(['prefix' => 'products'], function () {
    //  Route::get('/{id}', ['uses' => 'Api\V1\ProductController@Products']);
    Route::get('/search/{keywords}', ['uses' => 'Api\V1\ProductController@Search']);
    Route::get('/detail/{id}', ['uses' => 'Api\V1\ProductController@GetProductDetail']);
    Route::get('/latest', ['uses' => 'Api\V1\ProductController@GetLatestProducts']);
    Route::get('/featured', ['uses' => 'Api\V1\ProductController@GetFeaturedProducts']);
    Route::get('/top-rated', ['uses' => 'Api\V1\ProductController@GetTopRatedProducts']);
    //  Route::get('/by-category/{id}', ['uses' => 'Api\V1\ProductController@GetProductsByCategory']);
    Route::get('/by-brand/{id}', ['uses' => 'Api\V1\ProductController@GetProductsByBrand']);
    Route::get('/{id}/details', ['uses' => 'Api\V1\ProductController@GetProductDetail']);
    Route::get('/offers', ['uses' => 'Api\V1\ProductController@TodayOffers']);

    Route::get('/current-month-top-sold', ['uses' => 'Api\V1\ProductSoldController@getCurrentMonthTopSoldProducts']);
    Route::get('/current-year-top-sold', ['uses' => 'Api\V1\ProductSoldController@getCurrentYearTopSoldProducts']);
    Route::get('/all-time-top-sold', ['uses' => 'Api\V1\ProductSoldController@getAllTimeTopSoldProducts']);

});

Route::group(['prefix' => 'search'], function () {
    Route::get('/{keywords}', ['uses' => 'Api\V1\SearchKeywordController@SearchKeywords']);

});

Route::group(['prefix' => 'top-types'], function () {
    Route::get('/', ['uses' => 'Api\V1\TopTypeController@TopTypes']);
    Route::get('/{id}', ['uses' => 'Api\V1\TopTypeController@Products']);
});

Route::group(['prefix' => 'offers'], function () {
    Route::get('/', ['uses' => 'Api\V1\OfferController@GetOffers']);

});

Route::post('/product-request', ['uses' => 'Api\V1\ProductRequestController@store']);

Route::group(['prefix' => 'delivery-charges'], function () {

    Route::get('/get/', ['uses' => 'Api\V1\DeliveryChargeController@GetDeliveryCharges']);

});


/***
 * Auth restricted routes
 */

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/coupon/{code}/details', ['uses' => 'Api\V1\CouponController@CouponDetails']);
    Route::post('/coupon/verify', ['uses' => 'Api\V1\CouponController@CheckCoupon']);

    Route::post('orders/initiate_payment', 'Api\\V1\\OrderController@InitiatePayment');

    Route::post('/logout', ['uses' => 'Api\V1\AuthController@Logout']);
    Route::post('/change-password', ['uses' => 'Api\V1\AuthController@ChangePassword']);

    Route::post('/reset-password', ['uses' => 'Api\V1\AuthController@ResetPassword']);
    Route::get('/wallet', ['uses' => 'Api\V1\WalletController@GetWallet']);
    Route::get('/wallet/transactions', ['uses' => 'Api\V1\TransactionController@index']);

    Route::group(['prefix' => 'rating'], function () {
        Route::get('/review-product/{product}', ['uses' => 'Api\V1\RatingController@GetProductReviews']);
        Route::post('/review-product/{product}', ['uses' => 'Api\V1\RatingController@ReviewProduct']);
    });


    Route::group(['prefix' => 'profile'], function () {
        Route::post('/save', ['uses' => 'Api\V1\ProfileController@SaveProfile']);
        Route::get('/get', ['uses' => 'Api\V1\ProfileController@GetProfile']);
        Route::post('/change-email', ['uses' => 'Api\V1\ProfileController@ChangeEmail']);
        Route::post('/change-phone', ['uses' => 'Api\V1\ProfileController@ChangePhone']);

    });

    Route::group(['prefix' => 'address'], function () {
        Route::post('/save', ['uses' => 'Api\V1\AddressController@SaveAddress']);
        Route::get('/get', ['uses' => 'Api\V1\AddressController@GetAddress']);
        Route::get('/delete/{id}', ['uses' => 'Api\V1\AddressController@DeleteAddress']);

    });


    Route::get('/user', ['uses' => 'Api\V1\UserController@GetUser']);

    Route::group(['prefix' => 'orders'], function () {
        Route::post('/save', ['uses' => 'Api\V1\OrderController@SaveOrder']);
        Route::get('/by-user/', ['uses' => 'Api\V1\OrderController@GetOrdersByUser']);
        Route::get('/by-order-id/{id}', ['uses' => 'Api\V1\OrderController@GetOrderDetail']);
        Route::get('/status/{id}', ['uses' => 'Api\V1\OrderStatusController@GetOrderStatus']);
        Route::get('/get/{id}', ['uses' => 'Api\V1\OrderController@getOrderDetails']);
        Route::get('/reorder_status/{order}', 'Api\V1\OrderController@ReorderCurrentStatus');


    });

    Route::group(['prefix' => 'wish-list'], function () {
        Route::post('/save', ['uses' => 'Api\V1\WishListController@Store']);
        Route::post('/remove', ['uses' => 'Api\V1\WishListController@RemoveItem']);
        Route::get('/get/', ['uses' => 'Api\V1\WishListController@GetWishListsByUser']);
        Route::get('/by-order-id/{id}', ['uses' => 'Api\V1\OrderController@GetOrderDetail']);

    });

});

Route::group(['prefix' => 'guests'], function () {
    Route::post('/find_or_register', 'Api\V1\GuestChatController@FindGuest')->name('guest.register');
    Route::post('/guest_send_chat_message', 'Api\V1\GuestChatController@GuestSendChatMessage')->name('guest.send_message');
});

//Route::post('orders/ssl_ipn_listener', 'Api\\V1\\OrderController@SSLIpnListener');
//Route::get('orders/payment/success', 'Api\\V1\\OrderController@PaymentSuccessFull');
//Route::get('orders/payment/failed', 'Api\\V1\\OrderController@PaymentFailure');
//Route::get('orders/payment/canceled', 'Api\\V1\\OrderController@PaymentCanceled');


Route::group(['prefix' => 'orders'], function () {
    Route::post('ssl_ipn_listener', 'Api\\V1\\OrderController@SSLIpnListener');
    Route::get('payment/success', 'Api\\V1\\OrderController@PaymentSuccessFull');
    Route::get('payment/failed', 'Api\\V1\\OrderController@PaymentFailure');
    Route::get('payment/canceled', 'Api\\V1\\OrderController@PaymentCanceled');
    Route::get('get-order-by-unique-order-id/{uniqueOrderId}', ['uses' => 'Api\V1\OrderController@getOrderDetailsOrderUniqueId']);
});
