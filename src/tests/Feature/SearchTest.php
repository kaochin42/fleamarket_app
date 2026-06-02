<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Database\Seeders\ConditionSeeder;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ConditionSeeder::class);
    }

    // 1. 商品名で部分一致検索ができる
    public function test_search_by_partial_name()
    {
        $matchItem = Item::factory()->create(['name' => 'テスト商品']);
        $notMatchItem = Item::factory()->create(['name' => '全然関係ない商品']);

        $response = $this->get('/?keyword=テスト');

        $response->assertSee('テスト商品');
        $response->assertDontSee('全然関係ない商品');
    }

    // 2. 検索状態がマイリストでも保持されている
    public function test_search_keyword_is_kept_in_mylist()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/?tab=mylist&keyword=テスト');

        $response->assertSee('テスト');
    }
}
