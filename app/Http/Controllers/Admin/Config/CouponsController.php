<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Models\Coupons as ModelsCoupons;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    public function createCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'name' => 'required|string',
            'value' => 'required|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);

        $coupon = ModelsCoupons::create([
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'value' => $request->input('value'),
            'usage_limit' => $request->input('usage_limit'),
            '_status' => true,
            'expires_at' => $request->input('expires_at'),
        ]);

        return redirect()
            ->route('config.branch')
            ->with('success', 'Cupom criado com sucesso!');

    }
}
