<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Refund;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Withdraw;
use App\Packages\Wallet\WalletManager;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    private $globalObject;
    private $moduleName = "Refunds";
    private $singularVariableName = 'refund';
    private $pluralVariableName = 'refunds';

    private $retrievedDataList;
    private $singleData;

    public function __construct()
    {
        $this->globalObject = new Refund();
    }

    public function Index()
    {
        $this->authorize('viewAny', $this->globalObject);
        $this->retrievedDataList = $this->globalObject->GetRefundValues();
        //dd($this->retrievedDataList);
        return view('admin.' . $this->pluralVariableName . '.index', [
            $this->pluralVariableName => $this->retrievedDataList
        ]);
    }

    public function Create()
    {
        $this->authorize('create', $this->globalObject);
        $this->retrievedDataList = $this->globalObject->all();
        return view('admin.' . $this->pluralVariableName . '.create', [
            $this->pluralVariableName => $this->retrievedDataList
        ]);
    }

    public function Edit($id)
    {
        $data = $this->globalObject->findOrFail($id);

        $this->authorize('create', $data);

        return view('admin.' . $this->pluralVariableName . '.edit', [
            $this->singularVariableName => $data,
            $this->pluralVariableName => $this->globalObject->all()
        ]);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'order_item_id' => 'required'
        ]);
        $orderItem = OrderItem::with('order', 'product')->where('id', $request->order_item_id)->first();

        try{
            if (!empty($orderItem))
            {
                $order = $orderItem->order;
                if($order->status != 'pending')
                {
                    throw new \Exception('Order is not in pending status');
                }

                if($order->orderItems()->count() < 2)
                {
                    throw new \Exception('This order must have at least 2 items to refund');
                }

                $product = $orderItem->product;
                $product_id = $orderItem->product_id;
                $amount = $orderItem->price * $orderItem->quantity;

                $orderItem->delete();
                $this->globalObject->InitiateRefund($order->id, $orderItem);
                $this->globalObject->create($this->globalObject->GetData($order->id, $product_id, $order->user_id, $amount, $product->discount, $orderItem->quantity));
                return redirect()->back()->with(['success' => 'Item refunded successfully']);
            }
        }catch (\Exception $ex)
        {
            return redirect()->back()->with(['error' => $ex->getMessage()]);
        }

        return redirect()->back()->with(['error' => "OrderItem Not found"]);

    }


    public function shouldTerminateOrderRefund($order, $product_id)
    {
        if ($order->status != 'pending') return "You can not refund other that pending order";

        if (!empty($paymentMethod) && $paymentMethod->short_code !== 'ssl') return "You can not refund other than ssl gateway";


        $isOrderRefundedBefore = Refund::where('order_id', $order->id)->exists();
        if ($product_id == null && $isOrderRefundedBefore) return "You have already refunded this order";

        return "";

    }

    public function Update(Request $request)
    {
        return back();
    }

    public function Delete($id)
    {
        $refund = Refund::findOrFail($id);
        $this->authorize('delete', $refund);
        $refund->delete();
        return redirect()->back()->with(['success' => "Refund Deleted successfully"]);

    }

    public function ChangeStatus(Request $request)
    {

        $refund = Refund::findOrFail($request->id);
        if($refund->refunded_amount > 0)
        {
            $user = User::findOrFail($refund->user_id);
            $wallet = new WalletManager($user);
            try {
                if ($this->globalObject->ChangeRefundStatus($request->id, $request->status)) {
                    if ($request->status == 'refunded') {
                        $withdrewAmount = $wallet->withdrawFromUserWallet($refund->refunded_amount);
                        $refund->update(['withdraw' => $withdrewAmount]);
//                    $wallet->SaveOrUpdateWallet($refund->refunded_amount, 'sub');
                    }

                    return redirect()->back()->with(['success' => $this->moduleName . " updated successfully"]);
                }
            } catch (\Exception|QueryException $ex) {
                return redirect()->back()->with(['error' => $ex->getMessage()]);
            }
        }

        return redirect()->back()->with(['error' => "No amount withdrew!"]);

    }
}
