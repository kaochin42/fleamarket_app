<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function store(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withErrors([
                'password' => 'ログイン情報が登録されていません。',
            ]);
        }

        $request->session()->regenerate();

        if (!Auth::user()->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }
        
        return redirect()->route('item.index');
    }
}
