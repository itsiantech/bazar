<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DailyOrderExport implements FromView, ShouldAutoSize, WithStyles
{


    public function view(): View
    {
        $data = OrderItem::with('order','order.user', 'order.address', 'order.paymentMethod', 'product')->orderBy('order_id', 'desc')->get();

        $data = $this->formatData($data);

//        dd($data);

        return view('Exports.orders', [
            'orderItems' => $data
        ]);
    }

    private function formatData($data)
    {
        $formattedData = [];
        $previousOrderId = 0;
        foreach ($data as $item){
            if($item->order_id == $previousOrderId) $newOrder = false;
            else $newOrder = true;


            $previousOrderId = $item->order_id;
            $order = $item->order;
            $product = $item->product;
            if(!empty($order)){
                $user = $order->user;
                $address = $order->address;
                $paymentMode = $order->paymentMethod;
            }
            else{
                $user = [];
                $address = [];
                $paymentMode = [];
            }

            $prodQuantity = !empty($product)?$product->quantity:0;
            $prodUnitPrice = !empty($product)?$product->price_en:0;
            $product_total_price = $prodQuantity*$prodUnitPrice;

            if($newOrder){

                $productInformation = [
                    'product_link' => !empty($product)?route('product.edit', ['id' => $product->id]):'N/A',
                    'product_name' => !empty($product)?$product->name_en:'N/A',
                    'product_quantity' => $prodQuantity,
                    'product_unit_price' => $prodUnitPrice,
                    'product_total_price' => $product_total_price,
                ];

                $orderInformation = [
                    'order_date' => $item->created_at->format('d-m-y H:m:s'),
                    'order_unique_order_id' => !empty($order)?$order->unique_order_id:'N/A',
                    'order_status' => !empty($order)?$order->status:'N/A',
                    'order_amount' => !empty($order)?$order->calculateOriginalAmountAfterDiscount($order):0,
                    'order_delivery_charge' => !empty($order)?$order->delivery_charge:0,
                    'order_payment_mode' => !empty($paymentMode)?$paymentMode->name:'N/A',
                    'order_address' => !empty($address)?$address->address:'N/A',
                ];

                $userInformation = [
                    'user_id' => !empty($order)?$order->user_id:0,
                    'user_phone' => !empty($user)?$user->phone:'N/A',
                    'user_name' => !empty($user)?$user->name:'N/A',
                ];
            }else{
                $productInformation = [
                    'product_link' => !empty($product)?route('product.edit', ['id' => $product->id]):'N/A',
                    'product_name' => !empty($product)?$product->name_en:'N/A',
                    'product_quantity' => $prodQuantity,
                    'product_unit_price' => $prodUnitPrice,
                    'product_total_price' => $product_total_price,
                ];

                $orderInformation = [
                    'order_date' => '',
                    'order_unique_order_id' => '',
                    'order_status' => '',
                    'order_amount' => '',
                    'order_delivery_charge' => '',
                    'order_payment_mode' => '',
                    'order_address' => '',
                ];

                $userInformation = [
                    'user_id' => '',
                    'user_phone' => '',
                    'user_name' => '',
                ];
            }



            $formattedItem = array_merge($orderInformation, $userInformation, $productInformation);

            if($newOrder){
                $this->makeNewEmptyRow($formattedData);
                array_push($formattedData, json_decode(json_encode($formattedItem)));
                continue;
            }

            array_push($formattedData, json_decode(json_encode($formattedItem)));
        }

        return $formattedData;
    }

    private function makeNewEmptyRow(&$formattedData)
    {

        $emptyRowKey = [
            'order_date' => '',
            'order_unique_order_id' => '',
            'order_status' => '',
            'order_amount' => '',
            'order_delivery_charge' => '',
            'order_payment_mode' => '',
            'order_address' => '',
            'user_id' => '',
            'user_phone' => '',
            'user_name' => '',
            'product_link' => '',
            'product_name' => '',
            'product_quantity' => '',
            'product_unit_price' => '',
            'product_total_price' => '',

        ];

        $emptyRowKey = json_decode(json_encode($emptyRowKey));

        array_push($formattedData, $emptyRowKey);

    }


    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setOutlineLevel(1);
    }
}
