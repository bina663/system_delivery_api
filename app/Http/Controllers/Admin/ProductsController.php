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
        $categories = ModelsCategories::where('_status', true)
                    ->get();
        $additionals = ModelsAdditionals::where('_status', 1)->get();

        return view('admin.Products', compact('products','categories','additionals'));
    }

    public function createProducts(ProductsRequest $request)
    {
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
    }
    public function updateProducts(ProductsRequest $request, $id)
    {
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

        return redirect()
            ->route('admin.products.painel')
            ->with('success', 'Produto atualizado com sucesso!');
    }
    public function updateOrder(Request $request)
    {
        $Products = $request->input('Products');

        foreach ($Products as $products) {

            ModelsProducts::where('id', $products['id'])
                ->update([
                    'sort_order' => $products['position'],
                ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Ordem das categorias atualizada com sucesso!'
        ]);
    }
    public function toggleStatus(Request $request, $id)
    {
        $product = ModelsProducts::findOrFail($id);
        $product->_status = $request->_status;
        $product->save();

        return response()->json(['success' => true]);
    }
    public function deleteproducts(Request $request, $id)
    {
        ModelsProducts::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Produto deletado com sucesso!'
        ]);
    }
}
