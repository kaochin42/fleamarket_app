<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    // ログイン処理（認証失敗時はエラーメッセージを返す）
    public function store(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withErrors([
                'password' => 'ログイン情報が登録されていません。',
            ]);
        }

        // セッションの固定化攻撃を防ぐためセッションを再生成
        $request->session()->regenerate();

        // メール未認証の場合は認証ページに飛ぶ
        if (!Auth::user()->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return redirect()->route('item.index');
    }
}
