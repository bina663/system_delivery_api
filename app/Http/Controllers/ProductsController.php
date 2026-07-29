<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Http\Requests\Products\ProductsRequest;
class ProductsController extends Controller
{
    /**
     * Functions publicas para obter produtos da loja
    */
    //Pega produtos da lanchonete
    public function getProducts(){
        $products = Products::where('status', true)->get();
        return response()->json($products);
    }

    //Cadastro de produto
    public function createProduct(ProductsRequest $request){
        Products::create($request->validated());
        return response()->json(['success' => true, 'message' => 'Produto criado com sucesso']);
    }

    //Atualização de produto
    public function updateProduct(ProductsRequest $request, $id){
        $product = Products::find($id);
        if(!$product){
            return response()->json(['success' => false, 'message' => 'Produto não encontrado'], 404);
        }
        $product->update($request->validated());
        return response()->json(['success' => true, 'message' => 'Produto atualizado com sucesso']);
    }

    //Delete de produto
    public function deleteProduct(ProductsRequest $request, $id){
        $product = Products::find($id);
        if(!$product){
            return response()->json(['success' => false, 'message' => 'Produto não encontrado'], 404);
        }
        $product->delete([
            'status' => false
        ]);
        return response()->json(['success' => true, 'message' => 'Produto excluído com sucesso']);
    }
}
