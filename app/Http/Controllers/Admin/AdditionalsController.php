<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Additionals as ModelsAdditionals;
use App\Models\Categories as ModelsCategories;

class AdditionalsController extends Controller
{
    public function additionalsPainel()
    {
        $additionals = ModelsAdditionals::get();
        return view('admin.additionals', compact('additionals'));
    }

    public function createadditionals(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|numeric|min:0',
            '_status' => 'required|boolean'
        ]);



        ModelsAdditionals::create([
            'name' => $request->name,
            'value' => $request->value,
        ]);

        return redirect()
            ->route('admin.additionals.painel')
            ->with('success', 'Adicional criado com sucesso!');
    }
    public function updateadditionals(Request $request, $id)
    {
        $product = ModelsAdditionals::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            '_status' => 'required|boolean',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'value' => $request->value,
            'category_id' => $request->category_id,
            '_status' => $request->_status,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('additionals', 'public');
        }

        $product->update($data);

        return redirect()
            ->route('admin.additionals.painel')
            ->with('success', 'Produto atualizado com sucesso!');
    }
    public function updateOrder(Request $request)
    {
        $additionals = $request->input('additionals');

        foreach ($additionals as $additionals) {

            ModelsAdditionals::where('id', $additionals['id'])
                ->update([
                    'sort_order' => $additionals['position'],
                ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Ordem das categorias atualizada com sucesso!'
        ]);
    }

    public function toggleStatus(Request $request, $id)
    {
        $product = ModelsAdditionals::findOrFail($id);
        $product->_status = $request->_status;
        $product->save();

        return response()->json(['success' => true]);
    }
    public function destroyMultiple(Request $request)
    {
        $ids = $request->input('ids');

        ModelsAdditionals::whereIn('id', $ids)
            ->update([
                '_status' => false,
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Categorias excluídas com sucesso!'
        ]);
    }
}
