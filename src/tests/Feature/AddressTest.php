<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Address;
use Database\Seeders\ConditionSeeder;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ConditionSeeder::class);
    }

    // 1. 送付先住所変更画面にて登録した住所が商品購入画面に反映される
    public function test_address_is_reflected_in_purchase()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)->post('/purchase/address/' . $item->id, [
            'postcode' => '123-4567',
            'address' => 'テスト住所',
            'building' => 'テストビル',
        ]);

        $response = $this->actingAs($user)->get('/purchase/' . $item->id);

        $response->assertSee('テスト住所');
    }

    // 2. 購入した商品に送付先住所が紐づいて登録される
    // ※Stripe決済をスキップしてsuccessエンドポイントを直接テスト
    public function test_address_is_linked_to_purchase()
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
            'address_id' => $address->id,
        ]);
    }
}
