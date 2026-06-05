<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use Database\Seeders\ConditionSeeder;
use Database\Seeders\CategorySeeder;
use App\Models\Condition;

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
        $user = User::factory()->create(['name' => 'コメントユーザー']);
        $category = Category::first();
        $condition = Condition::first();

        $item = Item::factory()->create([
            'name' => 'テスト商品',
            'brand_name' => 'テストブランド',
            'description' => 'テスト説明',
            'price' => 1000,
            'condition_id' => $condition->id,
        ]);

        $item->categories()->attach($category->id);

        \App\Models\Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        \App\Models\Comment::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'テストコメント内容',
        ]);

        $response = $this->get('/item/' . $item->id);

        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('テスト説明');
        $response->assertSee('1,000');
        $response->assertSee('1');         // いいね数
        $response->assertSee('1');         // コメント数
        $response->assertSee($condition->name);  // 商品の状態
        $response->assertSee($category->name);   // カテゴリ
        $response->assertSee('コメントユーザー');  // コメントしたユーザー情報
        $response->assertSee('テストコメント内容'); // コメント内容
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
