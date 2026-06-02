<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Database\Seeders\ConditionSeeder;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    // ConditionSeederを呼びだす
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ConditionSeeder::class);
    }

    // 1. 全商品を取得できる
    public function test_all_items_are_displayed()
    {
        $items = Item::factory()->count(3)->create();

        $response = $this->get('/');

        foreach ($items as $item) {
            $response->assertSee($item->name);
        }
    }

    // 2. 購入済み商品は「Sold」と表示される
    public function test_sold_item_is_displayed()
    {
        $item = Item::factory()->create();
        $buyer = User::factory()->create();

        $address = \App\Models\Address::factory()->create([
            'user_id' => $buyer->id,
        ]);

        $item->purchases()->create([
            'user_id' => $buyer->id,
            'address_id' => $address->id,
            'payment' => 'card',
        ]);

        $response = $this->get('/');

        $response->assertSee('sold');
    }

    // 3. 自分が出品した商品は表示されない
    public function test_own_items_are_not_displayed()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'user_id' => $user->id,
            'name' => 'テスト出品商品',
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertDontSee($item->name);
    }
}
