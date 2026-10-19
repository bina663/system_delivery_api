<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\AdditionalsController;
use App\Http\Controllers\Admin\Config\BranchController;
use App\Http\Controllers\Admin\Config\CouponsController;
use App\Http\Controllers\Web\AuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\IndexController;


Route::get('/', [IndexController::class, 'cardapio'])->name('cardapio');
Route::get('/login', [IndexController::class, 'authentication'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.authenticate');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');
//Rotas de admin, acessadas apenas se tiverem autenticadas
Route::prefix('admin')->name('admin.')->middleware(['web', 'auth'])->group(function () {

    //Dashboard
    Route::get('/dashboard', [DashboardController::class, 'dashPainel'])->name('dashboard');

    //Pedidos
    Route::get('/orders', [OrdersController::class, 'ordersPainel'])->name('orders.painel');
    Route::patch('/orders/{order}/advance-status', [OrdersController::class, 'advanceStatus'])->name('orders.advance-status');
    Route::delete('/orders/{order}', [OrdersController::class, 'destroy'])->name('orders.destroy');
    Route::patch('/orders/{order}/pago', [OrdersController::class, 'marcarPago'])->name('orders.pago');
    Route::patch('/orders/{order}/cancel', [OrdersController::class, 'cancel'])->name('orders.cancel');

    // Categorias
    Route::get('/categories', [CategoryController::class, 'categoryPainel'])
        ->name('category.painel');
    Route::post('/categories', [CategoryController::class, 'createCategory'])
        ->name('categories.create');
    Route::post('/category/order', [CategoryController::class, 'updateOrder'])
        ->name('categories.order');
    Route::put('/categories/{id}', [CategoryController::class, 'updateCategory'])
        ->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'deleteCategoryPermanently'])
        ->name('categories.destroy');
    Route::patch('/categories/{id}/status', [CategoryController::class, 'toggleStatus'])
        ->name('categories.toggle-status');
    ;
    
    // Produtos
    Route::get('/products', [ProductsController::class, 'productsPainel'])
        ->name('products.painel');
    Route::post('/products', [ProductsController::class, 'createProducts'])
        ->name('products.create');
    Route::put('/products/{id}', [ProductsController::class, 'updateProducts'])
        ->name('products.update');
    Route::delete('/products/{id}', [ProductsController::class, 'deleteCategoryPermanently'])
        ->name('products.destroy');
    Route::patch('/products/{id}/status', [ProductsController::class, 'toggleStatus'])
        ->name('products.toggle-status');

    // Adicionais
    Route::get('/additionals', [AdditionalsController::class, 'additionalsPainel'])
        ->name('additionals.painel');
    Route::post('/additionals', [AdditionalsController::class, 'createAdditionals'])
        ->name('additionals.create');
    Route::put('/additionals/{id}', [AdditionalsController::class, 'updateAdditionals'])
        ->name('additionals.update');
    Route::delete('/additionals/{id}', [AdditionalsController::class, 'deleteCategoryPermanently'])
        ->name('additionals.destroy');
    Route::patch('/additionals/{id}/status', [AdditionalsController::class, 'toggleStatus'])
        ->name('additionals.toggle-status');

    // Configurações da loja
    Route::get('/settings/branch', [BranchController::class, 'branchPainel'])->name('branch.painel');
    Route::put('/settings/branch', [BranchController::class, 'branchUpdate'])->name('branch.update');

    //Coupons
    Route::post('/settings/branch/coupons', [CouponsController::class, 'createCoupon'])->name('coupons.create');
    Route::put('/settings/branch/coupons/{coupon}', [CouponsController::class, 'updateCoupon'])->name('coupons.update');
    Route::delete('/settings/branch/coupons/{coupon}', [CouponsController::class, 'deleteCoupon'])->name('coupons.destroy');
    Route::patch('/settings/branch/coupons/{coupon}/status', [CouponsController::class, 'toggleStatus'])->name('coupons.toggle-status');
    Route::patch('/settings/branch/coupons/{coupon}/reset-usage', [CouponsController::class, 'resetUsageCount'])->name('coupons.reset-usage');

});

Route::fallback(function () {
    return redirect('/');
});