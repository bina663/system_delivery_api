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

    public function toggleStatus(Request $request, $id)
    {
        $product = ModelsAdditionals::findOrFail($id);
        $product->_status = $request->_status;
        $product->save();

        return response()->json(['success' => true]);
    }

    public function deleteCategoryPermanently(Request $request, $id)
    {
        try {
            $product = ModelsAdditionals::findOrFail($id);

            $product->delete();

            return redirect()
                ->route('admin.additionals.painel')
                ->with('success', 'Adicional deletado com sucesso!');

        } catch (Exception $e) {

            return redirect()
                ->route('admin.additionals.painel')
                ->with('error', 'Erro ao deletar adicional.');
        }
    }
}
