<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    // プロフィール画面を表示（出品・購入した商品一覧も取得）
    public function show()
    {
        $user = auth()->user();
        // 自分が出品した商品を取得
        $sellItems = Item::where('user_id', $user->id)->get();
        // 自分が購入した商品を取得
        $buyItems = Item::whereIn('id', Purchase::where('user_id', $user->id)->pluck('item_id'))->get();

        // 購入済み商品のIDを取得（soldバッジ表示用）
        $purchasedItemIds = Purchase::pluck('item_id');
        
        return view('profiles.show', compact('user', 'sellItems', 'buyItems', 'purchasedItemIds'));
    }

    // プロフィール編集画面を表示
    public function edit()
    {
        $user = auth()->user();
        return view('profiles.edit', compact('user'));
    }

    // プロフィール情報を更新してマイページにリダイレクト
    public function update(ProfileRequest $request)
    {
        $user = auth()->user();
        $user->name = $request->name;
        $user->postcode = $request->postcode;
        $user->address = $request->address;
        $user->building = $request->building;

        // 画像がアップロードされた場合のみstorageに保存して更新
        if ($request->hasFile('profile_img')) {
            $path = $request->file('profile_img')->store('profiles', 'public');
            $user->profile_img = $path;
        }

        $user->save();
        return redirect()->route('mypage.show');
    }
}
