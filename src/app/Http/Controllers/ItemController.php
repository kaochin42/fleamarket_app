<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Condition;
use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::where('user_id', '!=', auth()->id())->get();
        return view('items.index', compact('items'));
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

    public function store(Request $request)
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
