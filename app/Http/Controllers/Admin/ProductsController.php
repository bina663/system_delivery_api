<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ProductsRequest;
use App\Models\Products as ModelsProducts;
use App\Models\Categories as ModelsCategories;
use App\Models\additionals as ModelsAdditionals;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function productsPainel()
    {
        $products = ModelsProducts::with([
            'categories',
            'additionals'
        ])->get();
        $categories = ModelsCategories::get();
        $additionals = ModelsAdditionals::where('_status', 1)->get();


        return view('admin.Products', compact('products','categories','additionals'));
    }

    public function createProducts(ProductsRequest $request)
    {
        try{
            $imagePath = null;

            // Upload da imagem
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('products', 'public');
            }

            // Cria o produto
            $product = ModelsProducts::create([
                'name' => $request->name,
                'value' => $request->value,
                'category_id' => $request->category_id,
                'status' => $request->_status,
                'description' => $request->description,
                'image' => $imagePath,
            ]);

            // Vincula os adicionais selecionados
            $product->additionals()->sync(
                $request->input('additionals', [])
            );

            return redirect()
                ->route('admin.products.painel')
                ->with('success', 'Produto criado com sucesso!');
        } catch (Exception $e) {
            return redirect()
                ->route('admin.products.painel')
                ->with('error', 'Erro ao criar produto'); 
        }
    }
    public function updateProducts(ProductsRequest $request, $id)
    {
        try {
            $product = ModelsProducts::findOrFail($id);

            $data = [
                'name' => $request->name,
                'value' => $request->value,
                'category_id' => $request->category_id,
                '_status' => $request->_status,
                'description' => $request->description,
            ];

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('products', 'public');
            }

            $product->update($data);

            // Atualiza os adicionais vinculados
            $product->additionals()->sync(
                $request->input('additionals', [])
            );

            return redirect()
                ->route('admin.products.painel')
                ->with('success', 'Produto atualizado com sucesso!');
        } catch (Exception $e) {
            return redirect()
                ->route('admin.products.painel')
                ->with('error', 'Erro ao atualizar produto.');
        }
    
    }
    public function toggleStatus(Request $request, $id)
    {
        $product = ModelsProducts::findOrFail($id);
        $product->_status = $request->_status;
        $product->save();

        return response()->json(['success' => true]);
    }
    public function deleteCategoryPermanently(Request $request, $id)
    {
        try {
            $product = ModelsProducts::findOrFail($id);

            $product->delete();

            return redirect()
                ->route('admin.products.painel')
                ->with('success', 'Produto deletado com sucesso!');

        } catch (Exception $e) {

            return redirect()
                ->route('admin.products.painel')
                ->with('error', 'Erro ao deletar produto.');
        }
    }
}
