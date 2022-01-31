<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Refund;
use App\Models\Wallet;
use App\Packages\Wallet\WalletManager;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    private $globalObject;
    private $moduleName='Order Items';

    private $retrievedDataList;
    private $singleData;

    public function __construct()
    {
        $this->globalObject = new OrderItem();
    }
    public function RemoveItem($id,Request $request)
    {
        $orderItem = OrderItem::with('order', 'order.orderItems')->where('id',$id)->first();
        try
        {
            $order = $orderItem->order;

            if($order->status != 'pending' && $order->status != 'accepted')
            {
                throw new \Exception('Order has to be in pending or accepted state');
            }

            $totalOrderItems = $order->orderItems->count();
            if($totalOrderItems > 1){
                $orderItem->delete();

                if ($this->globalObject->UpdateOrderValue($request,'remove', $orderItem)==1) return redirect()->back()->with(['success'=>'Item  removed successfully']);

            }
            return redirect()->back()->with(['error'=>  "Only one order item remains. So can not be removed"]);

        }catch (\Exception $ex){
            return redirect()->back()->with(['error'=>  $ex->getMessage()]);
        }


    }

    public function Refund(Request $request)
    {
        return redirect()->back()->with(['error'=>"Invalid order ID"]);
        $order = Order::where('unique_order_id',$request->order_id)->first();
        $product_id = (isset($request->product_id)?$request->product_id:null);
        $refund = new Refund();
        if($order){
            $refund = $refund->create($refund->GetData($order->id,$product_id,$order->user_id,$request->amount));
            if($refund){
                $orderItem = OrderItem::findOrFail($request->id);
                $orderItem->delete();
                if ($this->globalObject->UpdateOrderValue($request,'remove', $orderItem)==1) return redirect()->back()->with(['success'=> $this->moduleName." created successfully"]);;
                return redirect()->back()->with(['error'=>"Customer Wallet Update Failure"]);
            }
        }
        return redirect()->back()->with(['error'=>"Invalid order ID"]);

    }



    public function AddItem(Request $request)
    {
        $this->validate($request, [
            'order_id' => 'required|integer',
            'quantity' => 'required|integer',
        ]);


        try
        {
            $order = Order::findOrFail($request->order_id);

            if($order->status != 'pending' && $order->status != 'accepted')
            {
                throw new \Exception('Order has to be in pending or accepted state');
            }

            $orderItem = $this->globalObject->create($this->globalObject->GetData($request->all()));

            if ($this->globalObject->UpdateOrderValue($request,'add', $orderItem)==1)
            {
                return redirect()->back()->with(['success'=> $this->moduleName." created successfully"]);

            }
            else{
                return redirect()->back()->with(['error'=>  "Unable to update price But product added successfully"]);

            }

        }
        catch (\Exception|QueryException $ex)
        {
            return redirect()->back()->with(['error'=>$ex->getMessage()]);
        }

    }
}
