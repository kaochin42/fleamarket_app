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

        if ($request->has('payment')) {
            session(['payment' => $request->payment]);
        }

        return view('purchases.index', compact('item', 'user'));
    }

    public function store(PurchaseRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

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

        // 住所を保存
        $address = Address::create([
            'user_id'  => auth()->id(),
            'postcode' => session('postcode', auth()->user()->postcode),
            'address'  => session('address', auth()->user()->address),
            'building' => session('building', auth()->user()->building),
        ]);

        // セッションに保存しておく
        session([
            'stripe_session_id' => $session->id,
            'address_id' => $address->id,
            'payment' => $request->payment,
        ]);

        session()->forget(['postcode', 'address', 'building']);

        return redirect($session->url);
    }

    public function success($item_id)
    {
        Purchase::create([
            'user_id'    => auth()->id(),
            'item_id'    => $item_id,
            'address_id' => session('address_id'),
            'payment'    => session('payment'),
        ]);

        session()->forget(['stripe_session_id', 'address_id', 'payment']);

        return redirect()->route('item.index');
    }

    public function edit($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = auth()->user();

        return view('purchases.address', compact('item', 'user'));
    }

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
