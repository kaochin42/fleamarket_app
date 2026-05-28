<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        if ($request->tab === 'mylist') {
            $items = Item::whereHas('likes', function ($query) {
                $query->where('user_id', auth()->id());
            })->get();
        } else {
            $items = Item::where('user_id', '!=', auth()->id())->get();
        }

        $purchasedItemIds = Purchase::pluck('item_id');
        return view('items.index', compact('items', 'purchasedItemIds'));
    }

    public function show($item_id)
    {
        $item = Item::with(['categories', 'comments.user', 'condition', 'likes'])->findOrFail($item_id);
        return view('items.show', compact('item'));
    }

    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();
        return view('items.create', compact('categories', 'conditions'));
    }

    public function store(ExhibitionRequest $request)
    {
        $image_path = null;
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('items', 'public');
        }

        $item = Item::create([
            'user_id'      => auth()->id(),
            'name'         => $request->name,
            'brand_name'   => $request->brand_name,
            'description'  => $request->description,
            'price'        => $request->price,
            'condition_id' => $request->condition_id,
            'image_path'   => $image_path,
        ]);

        $item->categories()->attach($request->categories);

        return redirect()->route('item.index');
    }
}
