<?php

namespace App\Providers;

use App\Http\Requests\RoleRequest;
use App\Models\Slider;
use App\Policies\RolePolicy;
use App\Policies\SliderPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Role::class => RolePolicy::class,
        \App\Models\Slider::class => \App\Policies\SliderPolicy::class,
        \App\Models\Brand::class => \App\Policies\BrandPolicy::class,
        \App\Models\Bundle::class => \App\Policies\BundlePolicy::class,
        \App\Models\Category::class => \App\Policies\CategoryPolicy::class,
        \App\Models\Coupon::class => \App\Policies\CouponPolicy::class,
        \App\Models\DeliveryCharge::class => \App\Policies\DeliveryChargePolicy::class,
        \App\Models\Discount::class => \App\Policies\DiscountPolicy::class,
        \App\Models\Order::class => \App\Policies\OrderPolicy::class,
        \App\Models\Product::class => \App\Policies\ProductPolicy::class,
        \App\Models\User::class => \App\Policies\UserPolicy::class,
        \App\Models\ProductRequest::class => \App\Policies\ProductRequestPolicy::class,
        \App\Models\Refund::class => \App\Policies\RefundPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
