<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, $item_id)
    {
        Comment::create([
            'user_id' => auth()->id(),
            'item_id' => $item_id,
            'comment' => $request->comment,
        ]);

        return redirect()->route('item.show', ['item_id' => $item_id]);
    }
}
