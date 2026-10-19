<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryRequest;
use App\Models\Categories as ModelsCategories;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function categoryPainel()
    {
            $categories = ModelsCategories::orderBy('sort_order', 'asc')
            ->get();

        return view('admin.categories', compact('categories'));
    }

    public function createCategory(CategoryRequest $request)
    {
        $category = ModelsCategories::create($request->validated());

        return redirect()
            ->route('admin.category.painel')
            ->with('success', 'Categoria criada com sucesso!');
    }
    public function updateCategory(CategoryRequest $request, $id)
    {
        $category = ModelsCategories::findOrFail($id);

        $category->update($request->validated());

        return redirect()
            ->route('admin.category.painel')
            ->with('success', 'Categoria atualizada com sucesso!');
    }


    public function updateOrder(Request $request)
    {
        $categories = $request->input('categories');

        foreach ($categories as $category) {

            ModelsCategories::where('id', $category['id'])
                ->update([
                    'sort_order' => $category['position'],
                ]);
        }

        return redirect()
                ->route('admin.category.painel')
                ->with('success', 'Ordem das categorias atualizada com sucesso!');
    }
    public function deleteCategoryPermanently(Request $request, $id)
    {
        try {
            $category = ModelsCategories::findOrFail($id);

            $category->delete();

            return redirect()
                ->route('admin.category.painel')
                ->with('success', 'Categoria deletada com sucesso!');

        } catch (Exception $e) {

            return redirect()
                ->route('admin.category.painel')
                ->with('error', 'Erro ao deletar categoria.');
        }
    }
    public function toggleStatus(Request $request, $id)
    {
        $category = ModelsCategories::findOrFail($id);
        $category->_status = $request->_status;
        $category->save();

        return response()->json(['success' => true]);
    }

}
