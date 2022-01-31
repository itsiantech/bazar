<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductSold;
use App\Models\UserCoupon;
use App\Services\CouponService;
use App\Services\OrderService;
use Illuminate\Http\Client\Request;
use Illuminate\Routing\Route;

class OrderObserver
{

    /**
     * Handle the order "created" event.
     *
     * @param  \App\Models\Order  $order
     * @param  \App\Services\OrderService
     * @return void
     */
    public function created(Order $order )
    {
        $orderService = new OrderService();
        $orderId = $order->id;
        [$items, $products] = $orderService->GetOrderItemsArray(json_decode(json_encode(request()->cart_json))->order->orderItems,$orderId);
        OrderItem::insert($items);
        $this->updateProductSold($products);

    }

    private function updateProductSold($products)
    {
        foreach ($products as $index => $items)
        {
            $sold = new \App\Services\ProductSold();
            $sold->set($items);
            $sold->incrementSoldProduct();
        }
    }

    /**
     * Handle the order "updated" event.
     *
     * @param   \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        //
    }

    /**
     * Handle the order "deleted" event.
     *
     * @param   \App\Models\Order   $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the order "restored" event.
     *
     * @param   \App\Models\Order   $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the order "force deleted" event.
     *
     * @param   \App\Models\Order   $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
