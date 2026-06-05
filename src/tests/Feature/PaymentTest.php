<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Database\Seeders\ConditionSeeder;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ConditionSeeder::class);
    }

    // 小計画面で支払い方法の変更が反映される
    public function test_payment_method_is_reflected()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // セッションに支払い方法を保存
        $this->actingAs($user)->get('/purchase/' . $item->id . '?payment=コンビニ払い');

        // 購入画面で支払い方法が反映されてるか確認
        $response = $this->actingAs($user)->get('/purchase/' . $item->id);

        $response->assertSee('コンビニ払い');
    }
}
