<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use Illuminate\Http\Request;
use App\Models\Orders as ModelsOrders;

class OrdersController extends Controller
{
    public function ordersPainel()
    {
            $orders = ModelsOrders::with(['customer', 'items.product'])->where('_status', true)
            ->orderBy('created_at', 'desc') // mais recente primeiro
            ->get();

        return view('admin.orders', compact('orders'));
    }
    public function OrdermDelivery(ModelsOrders $order){
        $order->update(['status' => 'Finished']);
        return redirect()
            ->route('admin.orders.painel');
    }
    public function advanceStatus(ModelsOrders $order)
    {
        $next = $order->nextStatus();

        if ($next === null) {
            return redirect()
                ->route('admin.orders.painel')
                ->with('error', 'Este pedido já está na etapa final.');
        }

        $order->update(['status' => $next]);

        return redirect()
            ->route('admin.orders.painel')
            ->with('success', "Pedido #{$order->order_number} atualizado para \"{$order->status_label}\".");
    }
    public function cancel(ModelsOrders $order)
    {
        $order->update(['status' => ModelsOrders::STATUS_CANCELLED]);

        return redirect()
            ->route('admin.orders.painel')
            ->with('success', "Pedido #{$order->order_number} cancelado.");
    }
    public function destroy(ModelsOrders $order)
    {
        $order->update([
            '_status' => 0,
            'status' => 'removed',
        ]);
        return redirect()
            ->route('admin.orders.painel')
            ->with('success', "Pedido #{$order->order_number} removido.");
    }
}