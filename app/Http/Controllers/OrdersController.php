<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\orders;
use App\Http\Requests\Orders\OrdersRequest;
use App\Models\order_items;

class OrdersController extends Controller
{
    //creando um pedido
    public function createOrder(OrdersRequest $request){
        $order = orders::create($request->validated());

        order_items::create([
            'order_id' => $order->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'value' => $request->value,
            'notes' => $request->notes
        ]);
        return response()->json(['success' => true, 'message' => 'Pedido criado com sucesso', 'order_id' => $order->id]);
    }   

    //Obtendo pedidos
    public function getOrders(){
        $orders = orders::with('items')->get();
        return response()->json($orders);
    }   

    //Obtendo um pedido específico
    public function getOrder($id){
        $order = orders::with('items')->find($id);
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Pedido não encontrado'], 404);
        }
        return response()->json($order);
    }
    //Atualizando um pedido
    public function updateOrder(OrdersRequest $request, $id){
        $order = orders::find($id);
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Pedido não encontrado'], 404);
        }
        $order->update($request->validated());
        return response()->json(['success' => true, 'message' => 'Pedido atualizado com sucesso', 'order' => $order]);
    }
    //Deletando um pedido
    public function deleteOrder($id){
        $order = orders::find($id);
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Pedido não encontrado'], 404);
        }
        $order->delete();
        return response()->json(['success' => true, 'message' => 'Pedido excluído com sucesso']);
    }

    //Adicionando um produto a um pedido
    public function addProductToOrder(OrdersRequest $request, $orderId){
        $orderId = orders::find($orderId);
        if (!$orderId) {
            return response()->json(['success' => false, 'message' => 'Pedido não encontrado'], 404);
        }
        // Lógica para adicionar um produto a um pedido
        $orderId->items()->create($request->validated());
        return response()->json(['success' => true, 'message' => 'Produto adicionado ao pedido com sucesso']);
    }
    //Removendo um produto de um pedido
    public function removeProductFromOrder(Request $request, $orderId){
        $orderId = orders::find($orderId);
        if (!$orderId) {
            return response()->json(['success' => false, 'message' => 'Pedido não encontrado'], 404);
        }
        // Lógica para remover um produto de um pedido
        $orderId->items()->where('id', $request->item_id)->delete();
        return response()->json(['success' => true, 'message' => 'Produto removido do pedido com sucesso']);
    }
    //Adicionando um adicional a um pedido
    public function addAddonToOrder(OrdersRequest $request, $orderId){
        $orderId = orders::find($orderId);
        if (!$orderId) {
            return response()->json(['success' => false, 'message' => 'Pedido não encontrado'], 404);
        }
        // Lógica para adicionar um adicional a um pedido
        $orderId->addons()->create($request->validated());
        return response()->json(['success' => true, 'message' => 'Adicional adicionado ao pedido com sucesso']);
    }
    //Removendo um adicional de um pedido
    public function removeAddonFromOrder(OrdersRequest $request, $orderId){
        $orderId = orders::find($orderId);
        if (!$orderId) {
            return response()->json(['success' => false, 'message' => 'Pedido não encontrado'], 404);
        }
        // Lógica para remover um adicional de um pedido
        $orderId->addons()->where('id', $request->addon_id)->delete();
        return response()->json(['success' => true, 'message' => 'Adicional removido do pedido com sucesso']);
    }
    //Finalizando um pedido
    public function finalizeOrder($orderId){
        // Lógica para finalizar um pedido
        $orderId = orders::find($orderId);
        if (!$orderId) {
            return response()->json(['success' => false, 'message' => 'Pedido não encontrado'], 404);
        }
        $orderId->update(['status' => 'finalizado']);
        return response()->json(['success' => true, 'message' => 'Pedido finalizado com sucesso']);
    }
    //Cancelando um pedido
    public function cancelOrder($orderId){
        $orderId = orders::find($orderId);
        if (!$orderId) {
            return response()->json(['success' => false, 'message' => 'Pedido não encontrado'], 404);
        }
        // Lógica para cancelar um pedido
        $orderId->update(['status' => 'cancelado']);
        return response()->json(['success' => true, 'message' => 'Pedido cancelado com sucesso']);
    }
    //Obtendo o status de um pedido
    public function getOrderStatus($orderId){
        $orderId = orders::find($orderId);
        if (!$orderId) {
            return response()->json(['success' => false, 'message' => 'Pedido não encontrado'], 404);
        }
        // Lógica para obter o status de um pedido
        return response()->json(['success' => true, 'status' => $orderId->status]);
    }

}
