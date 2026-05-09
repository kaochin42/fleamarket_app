<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        return view('items.index');
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
