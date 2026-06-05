<?php

namespace App\Http\Controllers;
use App\Models\Like;

class LikeController extends Controller
{
    public function toggle($item_id)
    {
        $user_id = auth()->id();

        $like = Like::where('user_id', $user_id)
            ->where('item_id', $item_id)
            ->first();

        if ($like) {
            // すでにいいねしてる → 削除
            $like->delete();
        } else {
            // まだいいねしてない → 追加
            Like::create([
                'user_id' => $user_id,
                'item_id' => $item_id,
            ]);
        }

        return redirect()->route('item.show', ['item_id' => $item_id]);
    }
}
