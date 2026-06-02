<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use Database\Seeders\ConditionSeeder;
use Database\Seeders\CategorySeeder;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ConditionSeeder::class);
        $this->seed(CategorySeeder::class);
    }

    // 1. 必要な情報が表示される
    public function test_item_detail_is_displayed()
    {
        $item = Item::factory()->create([
            'name' => 'テスト商品',
            'brand_name' => 'テストブランド',
            'description' => 'テスト説明',
            'price' => 1000,
        ]);

        $response = $this->get('/item/' . $item->id);

        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('テスト説明');
        $response->assertSee('1,000');
    }

    // 2. 複数選択されたカテゴリが表示される
    public function test_multiple_categories_are_displayed()
    {
        $item = Item::factory()->create();

        $categories = Category::take(2)->get();
        $item->categories()->attach($categories->pluck('id'));

        $response = $this->get('/item/' . $item->id);

        foreach ($categories as $category) {
            $response->assertSee($category->name);
        }
    }
}
