<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Laravel\Mcp\Request;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\AddonsController;
use App\Http\Controllers\OrdersController;


/********************
 * Rotas da API
 * Desenvolvida por: Sabrina Oliveira
 * Data: 25/05/2026
 * ******************/



/**
 * Rotas sem autenticação para acessar
*/

/* Rota para autenticação */
Route::post('/auth', [AuthController::class, 'login']);

/*Produtos*/
//Pega produtos da lanchonete
Route::get('/products', [ProductsController::class, 'getProducts']);
/*Adicionais*/
Route::get('/additionals', [AddonsController::class, 'getAdditionals']);


/*Categoria*/
//Pega categorias da lanchonete que estão ativas
Route::get('/category', [CategoryController::class, 'getCategory']);
//Pega categoria especifica
Route::get('/category/{id}', [CategoryController::class, 'getCategory']);





//Rotas que precisa ser autenticadas para acessar
Route::middleware('auth:api')->group(function () {

    /**
     * Produtos
    */
    //Pega produtos da lanchonetev
    //Cadastro de produto
    Route::post('/products', [ProductsController::class, 'createProduct']);
    Route::put('/products/{id}', [ProductsController::class, 'updateProduct']);
    Route::delete('/products/{id}', [ProductsController::class, 'deleteProduct']);


    /**
     * Adicionais
    */
    Route::post('/additionals', [AddonsController::class, 'createAdditional']);
    Route::put('/additionals/{id}', [AddonsController::class, 'updateAdditional']);
    Route::delete('/additionals/{id}', [AddonsController::class, 'deleteAdditional']);

    /**
     * Categoria
    */
    Route::post('/category', [CategoryController::class, 'createCategory']);
    Route::put('/category/{id}', [CategoryController::class, 'updateCategory']);
    Route::delete('/category/{id}', [CategoryController::class, 'deleteCategory']);

    /*Pedidos*/
    Route::post('/orders', [OrdersController::class, 'createOrder']);
    Route::get('/orders', [OrdersController::class, 'getOrders']);
    Route::get('/orders/{id}', [OrdersController::class, 'getOrder']);
    Route::put('/orders/{id}', [OrdersController::class, 'updateOrder']);
    Route::delete('/orders/{id}', [OrdersController::class, 'deleteOrder']);
});
