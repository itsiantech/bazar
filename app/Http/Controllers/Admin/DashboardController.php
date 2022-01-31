<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function Index()
    {
        $orderObject = new Order();
        $userObject = new User();
        $users = User:: where('type','customer')->count();
        $newUsers = User::whereDate('created_at','=',Carbon::today())->where('type','customer')->count();
        $products = Product::where('is_deleted',0)->count();
        $orders = Order::count();
        $brands=Brand::count();
        $sales = Order::TotalSalesAmount();

//        List Data
        $newOrders = $orderObject->NewOrders('pending');
        $newUserList = User::with('roles')->whereDate('created_at','=',Carbon::today())->where('type','customer')->get();
        $scheduledOrders = Order::whereNotNull('schedule')->whereBetween('schedule', [now()->sub(2,'day'), now()])->orderBy('schedule', 'desc')->get();

        return view('admin.index',[
            'users'=>$users,
            'newUsers'=>$newUsers,
            'products'=>$products,
            'orders'=>$orders,
            'brands'=>$brands,
            'newOrders'=>$newOrders,
            'newUserList'=>$newUserList,
            'scheduledOrders'=>$scheduledOrders,
            'sales'=>$this->ThousandMillion(intval($sales))
        ]);
    }

    public function filterSalesByDate(Order $order)
    {
        $start = request('start');
        $end = request('end');

        $sales = [];
        try {
            $sales = $order->performDateRangeFilterOperation($start, $end, 'delivered');
            $allOrder = $order->performDateRangeFilterOperation($start, $end, 'all');

            $totalSales = $sales->sum('amount');
            $totalOrders = count($allOrder);
            return view('admin.Dashboard.dateWiseCardReport', ['totalSales' => $totalSales, 'totalOrders' => $totalOrders]);
        }catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return view('admin.Dashboard.dateWiseCardReport', ['orders' => $sales, 'totalSales' => 0, 'totalOrders' => 0]);
        }
    }

    public function ThousandMillion($price)
    {

        $thousands = $price % 1000000;

        $millions = ($price - $thousands)/1000000;

        $thousands = $thousands / 1000;
        if ($price>=1000000){
            return number_format($millions,2)." M";
        }
        else return $thousands .' K';
    }



}
