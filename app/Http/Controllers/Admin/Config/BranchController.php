<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Models\Branch as ModelsBranch;
use App\Models\Coupons as ModelsCoupons;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function branchPainel()
    {
        $branch = ModelsBranch::first();
        $coupons = ModelsCoupons::all();
        return view('config.branch', compact('branch', 'coupons'));
    }
    public function branchUpdate(Request $request)
    {
        $branch = ModelsBranch::find(1);

        $data = $request->except('image');

        if ($request->hasFile('image')) {

            // remove imagem antiga, se existir
            if ($branch->image && file_exists(public_path('storage/' . $branch->image))) {
                unlink(public_path('storage/' . $branch->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('storage/icon'), $imageName);

            $data['image'] = 'icon/' . $imageName;
        }

        $branch->update($data);

        return redirect()->back()->with('success', 'Configurações atualizadas com sucesso!');
    }
}
