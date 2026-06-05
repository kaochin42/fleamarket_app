<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Database\Seeders\ConditionSeeder;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ConditionSeeder::class);
    }

    // 必要な情報が取得できる（プロフィール画像、ユーザー名、出品した商品一覧、購入した商品一覧）
    public function test_profile_info_is_displayed()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'profile_img' => 'profiles/test.jpg',
        ]);
        $sellItem = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品テスト商品',
        ]);

        $buyItem = Item::factory()->create(['name' => '購入テスト商品']);
        $address = \App\Models\Address::factory()->create(['user_id' => $user->id]);
        $buyItem->purchases()->create([
            'user_id' => $user->id,
            'address_id' => $address->id,
            'payment' => 'card',
        ]);

        $response = $this->actingAs($user)->get('/mypage');

        $response->assertSee('テストユーザー');
        $response->assertSee('profiles/test.jpg');
        $response->assertSee('出品テスト商品');

        $response = $this->actingAs($user)->get('/mypage?page=buy');
        $response->assertSee('購入テスト商品');
    }
}
