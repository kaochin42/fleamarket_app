<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('items.index', compact('items'));
    }

    public function show($item_id)
    {
        return view('items.show');
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        // ここは後で保存処理を書く
    }
}
