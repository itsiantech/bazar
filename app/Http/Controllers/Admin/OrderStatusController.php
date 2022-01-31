<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Services\OrderService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    private $moduleName = "Order";
    private $singularVariableName = 'order';
    private $pluralVariableName = 'orders';
    private $globalObject;

    private $retrievedDataList;
    private $singleData;

    protected $rules = [
//        'current_order_status' => ['allowed_status'],
        'pending' => ['accepted', 'canceled'],
        'canceled' => ['pending', 'accepted', 'wallet_verify'],
        'accepted' => ['pending', 'on_delivery', 'canceled', 'order_processing'],
        'order_processing' => ['on_delivery'],
        'on_delivery' => ['delivered'],
        'delivered' => [],
    ];

    public function __construct()
    {
        $this->globalObject = new OrderStatus();
    }

    public function ChangeStatus(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
            'status' => 'required|string'
        ]);

        $order = Order::findOrFail($request->id);

        $this->checkOrderStatusCanBeChanged($order, $request->status);

        try {
            if ((new OrderService())->ChangeOrderStatus($request->id, $request->status)) {
                return redirect()->back()->with(['success' => $this->moduleName . " updated successfully"]);
            }
        } catch (QueryException $ex) {
            return redirect()->back()->with(['error' => $ex->getMessage()]);
        }
        return redirect()->back()->with(['error' => "Unable to handle this request !"]);
    }

    private function checkOrderStatusCanBeChanged($order, $requestedStatus):void
    {
        $orderStatus = $order->status;

        foreach ($this->rules as $state => $acceptedStatus)
        {
            // if ($orderStatus == $state && !in_array($requestedStatus, $acceptedStatus))
            // {
            //     abort(403, "You can not change to $requestedStatus status. The order is in $orderStatus state");
            // }

            if ($orderStatus == $state && in_array('wallet_verify', $acceptedStatus))
            {
                if (!($order->wallet_reduction < 1)) abort(403, "This order is already using wallet");

                if (!($order->cash_back < 1)) abort(403, "This order has cash back to wallet");
            }

        }

    }

}
