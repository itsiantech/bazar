<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DailyOrderExport;
use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\Refund;
use App\Models\SSLPaymentTransaction;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use function Psy\debug;

class OrderController extends Controller
{
    private $moduleName = "Order";
    private $singularVariableName = 'order';
    private $pluralVariableName = 'orders';
    private $globalObject;

    private $retrievedDataList;
    private $singleData;

    public function __construct()
    {
        $this->globalObject = new Order();
    }

    public function Index(Request $request)
    {
        $this->authorize('viewAny', $this->globalObject);

        $state = request('state');

        $this->retrievedDataList = $this->globalObject->GetOrders($state);

        return view('admin.orders.index', [
            'orders' => $this->retrievedDataList,
            'state' => $this->globalObject->checkOperationHasState($state)?$state:''
        ]);
    }

    public function getDateFilteredOrder(Request $request)
    {
        $this->authorize('viewAny', $this->globalObject);

        $this->validate($request, [
            'state' => 'required|string',
            'start' => 'required|date_format:Y-m-d',
            'end' => 'required|date_format:Y-m-d'
        ]);

        $state = request('state');
        $this->retrievedDataList = $this->globalObject->performDateRangeFilterOperation(request('start'), request('end'), $state);

        return view('admin.' . $this->pluralVariableName . '.index', [
            $this->pluralVariableName => $this->retrievedDataList,
            'state' => request('state')
        ]);
    }

    public function GetOrderByStatus(Request $request)
    {
        $this->authorize('viewAny', $this->globalObject);

        $orders = $this->globalObject->GetOrderByStatus($request->state);
        //dd($orders);
        $html = view('admin.orders.order_table', compact('orders'))->render();

        return $html;
    }

    public function Detail($id)
    {
        $this->singleData = $this->globalObject->GetDetail($id);

        $this->authorize('view', $this->singleData);


        return (new OrderService())->getOrderDetail($this->singleData, true);
    }




    public function Discount(Request $request)
    {

        $this->authorize('discount', $this->globalObject);

        if ($this->globalObject->AddDiscountToOrder($request->id, $request->discount_id)) {
            return redirect()->back()->with(['success' => 'Discount added successfully']);
        }
        return redirect()->back()->with(['error' => 'unable to add Discount']);
    }

    public function destroy($id)
    {
        $data = $this->globalObject->findOrFail($id);
        $this->authorize('delete', $data);
        $data->orderItems()->delete();
        $data->delete();
        return redirect()->back()->with(['success' => $this->moduleName . "  deleted successfully"]);
    }

    public function invoice($id)
    {
        $this->singleData = $this->globalObject->GetDetail($id);
        $this->authorize('view', $this->singleData);
//        $products = $this->globalObject->CheckBundle($this->singleData->orderItems);
        $products = $this->singleData->orderItems;
        $discounts = Discount::all();

        $total = $this->globalObject->GetAmount($this->singleData);

        return view('admin.' . $this->pluralVariableName . '.invoice', [
            $this->singularVariableName => $this->singleData,
            'discounts' => $discounts,
            'products' => $products,
            'total' => $total,
        ]);

    }

    public function SSLResponseIndex()
    {
        $sslResponse = SSLPaymentTransaction::latest()->get();

        return view("admin.".$this->pluralVariableName.".ssl_response_index", compact('sslResponse'));
    }

    public function ExportDailyOrders()
    {
        return Excel::download(new DailyOrderExport(), 'orders-'.now()->format('y-m-d').'.xlsx');

    }

}
