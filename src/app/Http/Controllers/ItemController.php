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
    // 商品一覧画面を表示（タブ切替・キーワード検索に対応）
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        if ($request->tab === 'mylist') {
            $items = Item::whereHas('likes', function ($query) {
                $query->where('user_id', auth()->id());
            })->searchName($keyword)->get();
        } else {
            $items = Item::where('user_id', '!=', auth()->id())->searchName($keyword)->get();
        }

        // 購入済み商品のIDを取得（soldバッジ表示用）
        $purchasedItemIds = Purchase::pluck('item_id');
        return view('items.index', compact('items', 'purchasedItemIds', 'keyword'));
    }

    // 商品詳細画面を表示（カテゴリ・コメント・いいね情報を一緒に取得）
    public function show($item_id)
    {
        $item = Item::with(['categories', 'comments.user', 'condition', 'likes'])->findOrFail($item_id);
        return view('items.show', compact('item'));
    }

    // 商品出品画面を表示（カテゴリ・コンディション一覧をビューに渡す）
    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();
        return view('items.create', compact('categories', 'conditions'));
    }

    // 出品商品を保存して商品一覧にリダイレクト
    public function store(ExhibitionRequest $request)
    {
        // 商品画像をstorageに保存
        $image_path = null;
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('items', 'public');
        }

        // 商品情報をDBに保存
        $item = Item::create([
            'user_id'      => auth()->id(),
            'name'         => $request->name,
            'brand_name'   => $request->brand_name,
            'description'  => $request->description,
            'price'        => $request->price,
            'condition_id' => $request->condition_id,
            'image_path'   => $image_path,
        ]);

        // 中間テーブルにカテゴリを保存（多対多）
        $item->categories()->attach($request->categories);

        return redirect()->route('item.index');
    }
}
