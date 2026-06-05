<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use App\Models\Address;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        $user = auth()->user();

        // セッションのitem_idと違う商品なら支払い方法をリセット
        if (session('current_item_id') !== $item_id) {
            session()->forget('payment');
            session(['current_item_id' => $item_id]);
        }

        // 支払い方法が選択されたらセッションに保存（画面リロード時に保持するため）
        if ($request->has('payment')) {
            session(['payment' => $request->payment]);
        }

        return view('purchases.index', compact('item', 'user'));
    }

    // Stripe決済セッションを作成して決済画面にリダイレクト
    public function store(PurchaseRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        // StripeのAPIキーをセット
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        // Stripe決済セッションを作成（支払い方法によってコンビニ/カードを切り替え）
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => $request->payment === 'カード払い' ? ['card'] : ['konbini'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('purchase.success', ['item_id' => $item_id]),
            'cancel_url' => route('purchase.index', ['item_id' => $item_id]),
        ]);

        // 配送先住所をaddressesテーブルに保存（セッションの値を優先、なければユーザーのプロフィール住所を使用）
        $address = Address::create([
            'user_id'  => auth()->id(),
            'postcode' => session('postcode', auth()->user()->postcode),
            'address'  => session('address', auth()->user()->address),
            'building' => session('building', auth()->user()->building),
        ]);

        // 購入完了処理（success）で使うためにセッションに保存
        session([
            'stripe_session_id' => $session->id,
            'address_id' => $address->id,
            'payment' => $request->payment,
        ]);

        session()->forget(['postcode', 'address', 'building']);

        return redirect($session->url);
    }

    // Stripe決済完了後の処理（購入情報をDBに保存して商品一覧にリダイレクト）
    public function success($item_id)
    {
        // 購入情報をpurchasesテーブルに保存
        Purchase::create([
            'user_id'    => auth()->id(),
            'item_id'    => $item_id,
            'address_id' => session('address_id'),
            'payment'    => session('payment'),
        ]);

        // 使用済みセッションを削除
        session()->forget(['stripe_session_id', 'address_id', 'payment']);

        return redirect()->route('item.index');
    }

    // 送付先住所変更画面を表示
    public function edit($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = auth()->user();

        return view('purchases.address', compact('item', 'user'));
    }

    // 送付先住所をセッションに保存して購入画面にリダイレクト（DBには保存しない）
    public function update(AddressRequest $request, $item_id)
    {
        session([
            'postcode' => $request->postcode,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        return redirect()->route('purchase.index', ['item_id' => $item_id]);
    }

}
