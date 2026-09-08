<?php

namespace App\Http\Controllers\Web;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ProductsController;
use App\Models\Products;

class IndexController extends Controller
{

    //Exibindo pagina principal do cardapip
    public function cardapio(){
        $products = Products::where('status', true)->get();
        return view('web.cardapio',['products' => $products]);
    }

    public function authentication(){
        return view('web.login');
    }
}
