<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderReportController extends Controller
{
    public function MonthlyOrderReportGraph()
    {
        $orders = Order::select('created_at')->whereYear('created_at', now()->format('Y'))->get()->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('M'); // grouping by years
        });

        $orderReport = [];
        foreach ($orders as $month => $order) {
            array_push($orderReport, ['month' => (string)$month, 'value' => count($order)]);
        }

        return response()->json($orderReport);
    }

    public function DailyOrderReportGraph()
    {
        $orders = Order::select('created_at')
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->orderBy('created_at', 'asc')
            ->get()->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('d'); // grouping by years
            });

        $previousOrders = Order::select('created_at')
            ->whereMonth('created_at', date('m', strtotime('last month')))
            ->whereYear('created_at', date('Y'))
            ->orderBy('created_at', 'asc')
            ->get()->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('d'); // grouping by years
            });


        $orderReportCurrent = [];
        foreach ($orders as $month => $order) {
            $orderReportCurrent[(string)$month] = count($order);
        }

        $orderReportPrevious = [];
        foreach ($previousOrders as $month => $order) {
            $orderReportPrevious[(string)$month] = count($order);
        }

        $orderReport = [];
        for ($i = 1; $i <= 31; $i++){
            $day = sprintf("%02d", $i);
            $currentDayOrder = 0;
            $previousDayOrder = 0;
            if (array_key_exists($day, $orderReportCurrent)) $currentDayOrder = $orderReportCurrent[$day];
            if (array_key_exists($day, $orderReportPrevious)) $previousDayOrder = $orderReportPrevious[$day];

            if($currentDayOrder > 0 || $previousDayOrder > 0){
                array_push($orderReport,[
                    'day' => $day,
                    'current' => $currentDayOrder,
                    'previous' => $previousDayOrder
                ]);
            }
        }

        return response()->json($orderReport);
    }

    public function YearlyOrderReportGraph()
    {
        $orders = Order::select('created_at')
            ->orderBy('created_at', 'asc')
            ->get()->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('Y'); // grouping by years
            });

        $orderReport = [];
        $nextYear = 0;
        foreach ($orders as $year => $order) {
            array_push($orderReport, ['year' => (string)$year, 'value' => count($order)]);
            $nextYear = $year + 1;
        }

        if(count($order) < 1) $nextYear = now()->format("Y");

        array_push($orderReport, ['year' => $nextYear, 'value' => 0]);

        return response()->json($orderReport);
    }
}
