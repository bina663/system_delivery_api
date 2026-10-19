<?php

namespace App\Http\Controllers\Web;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ProductsController;

use App\Models\Products as ModelsProducts;
use App\Models\Categories as ModelsCategories;
class IndexController extends Controller
{

    //Exibindo pagina principal do cardapip
    public function cardapio()
    {
        $categories = ModelsCategories::where('_status', true)
            ->with(['products' => function ($query) {
                $query->where('_status', true)
                    ->with(['additionals' => function ($query) {
                        $query->where('_status', true);
                    }]);
            }])
            ->orderBy('sort_order')
            ->get();

        return view('web.cardapio', ['categories' => $categories]);
    }
    public function authentication(){
        return view('web.login');
    }
}
