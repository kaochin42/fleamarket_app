<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index($item_id)
    {
        return view('purchases.index');
    }

    public function store(Request $request)
    {
        // ここは後で保存処理を書く
    }

    public function edit($item_id)
    {
        return view('purchases.address');
    }

    public function update(Request $request)
    {
        // return redirect()->route('purchase.index', ['item_id' => $request->item_id]);
        return "住所を更新しました";
    }

}
