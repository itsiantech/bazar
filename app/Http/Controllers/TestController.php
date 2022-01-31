<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public array $ignoreCols = ['id'];


    public function all()
    {
        $users = User::query()
            ->select('email', 'phone', 'provider_id')
            ->with('orders', 'orders.orderItems')
            ->whereYear('created_at', now()->format('Y'))
            ->whereMonth('created_at', '05')
            ->whereDay('created_at', '>=', '20')
            ->whereDay('created_at', '<', '22')
            ->get();

        $orders = Order::query()
            ->with('orderItems', 'user', 'orderItems.product')
            ->whereYear('created_at', now()->format('Y'))
            ->whereMonth('created_at', '05')
            ->whereDay('created_at', '>', '20')
            ->whereDay('created_at', '<=', '22')
            ->get();
        return [
            'users' => $users,
            'orders' => $orders
        ];
    }


    public function get()
    {
        $response = Http::get('https://test.bangoshop.com/api/all');
        if ($response->status() == 200) {
            $data = $response->json();
            $orders = $data['orders'];
            $users = [];
            $newOrdersToBeCreated = [];
            $defectedOrdersIndex = [];
            $productNotFound = [];
            foreach ($orders as $order) {
                $user = User::query()
                    ->where('email', $order['user']['email'])
                    ->where('phone', $order['user']['phone'])
                    ->where('provider', $order['user']['provider'])
                    ->where('provider_id', $order['user']['provider_id'])
                    ->first();

                if(empty($user)){
                    dd($order);
                }
                $order['user_id'] = $user->id;
//            dd($order, $user, $orders);

                $items = [];
                $isDefected = false;
                foreach ($order['order_items'] as $oi) {
                    if (!empty($oi)) {
                        $product = Product::find($oi['product_id']);

                        if (!empty($product)) {
                            $oi['product'] = $product;
                            array_push($items, $oi);
                        }
                        elseif (empty($product) && !in_array($oi['product_id'], $productNotFound)) {
                            array_push($productNotFound, $oi['product_id']);
                            $isDefected = true;
                        }

                    }
                }
                $order['order_items'] = $items;
                $order['user'] = $user;


                array_push($users, $user);
                if ($isDefected) array_push($defectedOrdersIndex, count($newOrdersToBeCreated));
                array_push($newOrdersToBeCreated, $order);

            }

            $ignoreOrderCol = ['id','order_items','user'];
            $ignoreOrderItemCol = ['id','product', 'order_id'];
            $newDefectedOrderId = [];
//            dd($newOrdersToBeCreated, $productNotFound, $defectedOrdersIndex);
            foreach ($newOrdersToBeCreated as $key => $newOrder)
            {
                $items = $newOrder['order_items'];
                $order = new Order();
                foreach ($newOrder as $col => $value){
//                dd($newOrder, $col);
                    if(!in_array($col, $ignoreOrderCol)) $order->$col = $value;
                }
            $order->save();
                $newOrderId = $order->id;
                if(in_array($key, $defectedOrdersIndex)) array_push($newDefectedOrderId, $newOrderId);

//            dd($items);
                foreach ($items as $item){
                    $orderItem = new \App\Models\OrderItem();
                    foreach ($item as $col => $value){
                        if(!in_array($col, $ignoreOrderItemCol)) $orderItem->$col = $value;
                    }
                    $orderItem->order_id = $newOrderId;
                $orderItem->save();
                }

            }
            Log::error(json_encode(['defectedOrderId' => $newDefectedOrderId, 'products' => $productNotFound]));

            return $newDefectedOrderId;
        } else {
            return $response->status();
        }

    }


    public function allUser()
    {
        $users = DB::table('users')
            ->where('type', 'customer')
            ->selectRaw('users.*')
            ->get();

        return [
            'users' => $users,
        ];
    }



    public function allUserGet()
    {

        $response = Http::get('https://test.bangoshop.com/api/all-user');
        if ($response->status() == 200) {
            $data = $response->json();
            $remoteUsers = $data['users'];

            foreach ($remoteUsers as $user)
            {
                $isUserExist = User::query()
                    ->where('email', $user['email'])
                    ->where('phone', $user['phone'])
                    ->where('provider', $user['provider'])
                    ->where('provider_id', $user['provider_id'])
                    ->exists();

                if(!$isUserExist) $this->build(User::class, $user, true, false);
            }


        }

    }


    private function build(string $model, $data, bool $shouldSave = true, bool $debug = false)
    {
        $m = new $model;
        foreach ($data as $col => $val)
        {
            if($debug) dd($data, $col, $val);
            if(!in_array($col, $this->ignoreCols)) $m->$col = $val;
        }

        if($shouldSave) $m->save();

        return $m;
    }
}
