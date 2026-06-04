<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// --- 誰でも閲覧可能なルート（認証不要） ---
Route::post('/login', [LoginController::class, 'store'])->name('login');
Route::get('/', [ItemController::class, 'index'])->name('item.index');
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('item.show');

// --- ログインユーザーのみアクセス可能なルート（要認証） ---
Route::middleware(['auth', 'verified'])->group(function () {

    // 商品出品関連 (ItemController)
    Route::get('/sell', [ItemController::class, 'create'])->name('item.create');
    Route::post('/sell', [ItemController::class, 'store'])->name('item.store');

    // 配送先住所変更 (PurchaseController)
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'edit'])->name('address.edit');
    Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'update'])->name('address.update');

    // 商品購入関連 (PurchaseController)
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'index'])->name('purchase.index');
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'store'])->name('purchase.store');
    // stripe
    Route::get('/purchase/{item_id}/success', [PurchaseController::class, 'success'])->name('purchase.success');

    // コメント関連（CommentController）
    Route::post('/item/{item_id}/comment', [CommentController::class, 'store'])->name('comment.store');

    // プロフィール関連 (ProfileController)
    Route::get('/mypage', [ProfileController::class, 'show'])->name('mypage.show');
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');

    // いいね関連（LikeController）
    Route::post('/item/{item_id}/like', [LikeController::class, 'toggle'])->name('like.toggle')->middleware('auth');
});
