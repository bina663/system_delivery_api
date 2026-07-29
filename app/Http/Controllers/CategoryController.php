<?php

namespace App\Http\Controllers;

use App\Http\Controllers\RequestController;
use App\Models\Category;
use App\Http\Requests\Category\CategoryRequest;

class CategoryController extends Controller
{
    /*
        Funções publicas para obter categorias da loja
        caso queira pegar categorias especificas e passar o id da categoria, basta usar a função getCategory e passar o id como parametro, exemplo: /category/1
    */
    
    public function getCategory($id = null){
        if ($id) {
            return Category::find($id);
        }
        return Category::where('status', '=', true)->get();
    }

    /*Cadastro de categoria*/
    public function createCategory(CategoryRequest $request){
        //valida se a categoria ja e existente
        if (Category::where('name', $request->name)->exists()) {
            return response()->json(['success' => false, 'message' => 'Categoria já existe']);
        }

        Category::create($request->validated());
        return response()->json(['success' => true, 'message' => 'Categoria criada com sucesso']);
    }

    /*Atualização de categoria*/
    public function updateCategory(CategoryRequest $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Categoria não encontrada'
            ], 404);
        }

        $category->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Categoria atualizada com sucesso'
        ]);
    }
    /*Em vez de deletar a categoria, vamos apenas marcar como inativa*/
    public function deleteCategory(CategoryRequest $request, $id){
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Categoria não encontrada']);
        }

        //Em vez de deletar a categoria, vamos apenas marcar como inativa
        $category->update([
            'status' => '0'
        ]);
        return response()->json(['success' => true, 'message' => 'Categoria deletada com sucesso']);
    }   
}
