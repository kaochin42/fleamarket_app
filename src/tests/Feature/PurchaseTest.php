<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Address;
use Database\Seeders\ConditionSeeder;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ConditionSeeder::class);
    }

    // 1. 「購入する」ボタンを押下すると購入が完了する
    public function test_purchase_is_completed()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $address = Address::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)->withSession([
            'address_id' => $address->id,
            'payment' => 'card',
        ])->get('/purchase/' . $item->id . '/success');

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    // 2. 購入した商品は商品一覧画面にて「sold」と表示される
    public function test_purchased_item_shows_sold()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['name' => 'テスト商品']);
        $address = Address::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)->withSession([
            'address_id' => $address->id,
            'payment' => 'card',
        ])->get('/purchase/' . $item->id . '/success');

        $response = $this->get('/');

        $response->assertSee('sold');
    }

    // 3. 購入した商品がプロフィールの購入した商品一覧に追加される
    public function test_purchased_item_is_in_profile()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['name' => 'テスト商品']);
        $address = Address::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)->withSession([
            'address_id' => $address->id,
            'payment' => 'card',
        ])->get('/purchase/' . $item->id . '/success');

        $response = $this->actingAs($user)->get('/mypage?page=buy');

        $response->assertSee('テスト商品');
    }
}
