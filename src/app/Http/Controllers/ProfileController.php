<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $sellItems = Item::where('user_id', $user->id)->get();
        $buyItems = Item::whereIn('id', Purchase::where('user_id', $user->id)->pluck('item_id'))->get();
        $purchasedItemIds = Purchase::pluck('item_id');
        return view('profiles.show', compact('user', 'sellItems', 'buyItems', 'purchasedItemIds'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('profiles.edit', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = auth()->user();
        $user->name = $request->name;
        $user->postcode = $request->postcode;
        $user->address = $request->address;
        $user->building = $request->building;
        if ($request->hasFile('profile_img')) {
            $path = $request->file('profile_img')->store('profiles', 'public');
            $user->profile_img = $path;
        }
        
        $user->save();
        return redirect()->route('mypage.show');
    }
}
