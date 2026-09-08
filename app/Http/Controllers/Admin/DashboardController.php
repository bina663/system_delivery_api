<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders as ModelsOrders;

class DashboardController extends Controller
{
    public function dashPainel()
    {
        $ordersPending = ModelsOrders::where([
            ['status', 'pending'],
            ['_status', true],
        ])->count();
        $ordersPreparing = ModelsOrders::where([
            ['status', 'preparing'],
            ['_status', true],
        ])->count();
        $ordersOutDelivery = ModelsOrders::where([
            ['status', 'out_for_delivery'],
            ['_status', true],
        ])->count();
        $ordersDelivery = ModelsOrders::where([
            ['status', 'delivery'],
            ['_status', true],
        ])->count();
        $ordersCancel = ModelsOrders::where([
            ['status', 'cancel'],
            ['_status', false],
        ])->count();

        $ordersValueTotal = ModelsOrders::whereIn('status', ['preparing', 'out_for_delivery', 'delivery'])
        ->where('_status', true)
        ->sum('total');
        return view('admin.dashboard', compact(
            'ordersPending',
            'ordersPreparing',
            'ordersOutDelivery',
            'ordersDelivery',
            'ordersCancel',
            'ordersValueTotal'
        ));
    }
}
