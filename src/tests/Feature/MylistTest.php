<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;
use Database\Seeders\ConditionSeeder;

class MylistTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ConditionSeeder::class);
    }

    // 1. いいねした商品だけが表示される
    public function test_only_liked_items_are_displayed()
    {
        $user = User::factory()->create();
        $likedItem = Item::factory()->create(['name' => 'いいねした商品']);
        $notLikedItem = Item::factory()->create(['name' => 'いいねしてない商品']);

        Like::create([
            'user_id' => $user->id,
            'item_id' => $likedItem->id,
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertSee('いいねした商品');
        $response->assertDontSee('いいねしてない商品');
    }

    // 2. 購入済み商品は「sold」と表示される
    public function test_sold_item_is_displayed_in_mylist()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $address = \App\Models\Address::factory()->create([
            'user_id' => $user->id,
        ]);

        $item->purchases()->create([
            'user_id' => $user->id,
            'address_id' => $address->id,
            'payment' => 'card',
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertSee('sold');
    }

    // 3. 未認証の場合は何も表示されない
    public function test_mylist_is_empty_for_guest()
    {
        $item = Item::factory()->create(['name' => 'テスト商品']);

        $response = $this->get('/?tab=mylist');

        $response->assertDontSee('テスト商品');
    }
}
