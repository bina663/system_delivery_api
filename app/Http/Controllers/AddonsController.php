<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Additionals;
use App\Http\Requests\Addon\AddonsRequest;

class AddonsController extends Controller
{
    //Pegando adicionais da lanchonete
    public function getAdditionals(){
        $additionals = Additionals::where('status', true)->get();
        return response()->json($additionals);
    }  

    //Cadastro de adicional
    public function createAdditional(AddonsRequest $request){
        Additionals::create($request->validated());
        return response()->json(['success' => true, 'message' => 'Adicional criado com sucesso']);
    }
    
    //Atualização de adicional
    public function updateAdditional(AddonsRequest $request, $id){
        $additional = Additionals::find($id);
        if(!$additional){
            return response()->json(['success' => false, 'message' => 'Adicional não encontrado'], 404);
        }
        $additional->update($request->validated());
        return response()->json(['success' => true, 'message' => 'Adicional atualizado com sucesso']);
    }

    //Delete de adicional
    public function deleteAdditional(AddonsRequest $request, $id){
        $additional = Additionals::find($id);
        if(!$additional){
            return response()->json(['success' => false, 'message' => 'Adicional não encontrado'], 404);
        }
        $additional->delete([
            'status' => false
        ]);
        return response()->json(['success' => true, 'message' => 'Adicional excluído com sucesso']);
    }
}
