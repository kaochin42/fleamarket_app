<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Address;
use App\Models\Purchase;

class PurchaseController extends Controller
{
    public function index($item_id)
    {
        $item = Item::findOrFail($item_id);

        $user = auth()->user();

        return view('purchases.index', compact('item', 'user'));
    }

    public function store(Request $request, $item_id)
    {
        $address = Address::create([
            'user_id'  => auth()->id(),
            'postcode' => session('postcode', auth()->user()->postcode),
            'address'  => session('address', auth()->user()->address),
            'building' => session('building', auth()->user()->building),
        ]);

        Purchase::create([
            'user_id'    => auth()->id(),
            'item_id'    => $item_id,
            'address_id' => $address->id,
            'payment'    => $request->payment,
        ]);

        session()->forget(['postcode', 'address', 'building']);

        return redirect()->route('item.index');
    }

    public function edit($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = auth()->user();

        return view('purchases.address', compact('item', 'user'));
    }

    public function update(Request $request, $item_id)
    {
        session([
            'postcode' => $request->postcode,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        return redirect()->route('purchase.index', ['item_id' => $item_id]);
    }

}
