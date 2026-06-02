<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Condition;
use Database\Seeders\ConditionSeeder;
use Database\Seeders\CategorySeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ExhibitionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ConditionSeeder::class);
        $this->seed(CategorySeeder::class);
    }

    // 商品出品画面にて必要な情報が保存できる
    public function test_exhibition_can_be_stored()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $category = Category::first();
        $condition = Condition::first();

        $response = $this->actingAs($user)->post('/sell', [
            'name' => 'テスト商品',
            'brand_name' => 'テストブランド',
            'description' => 'テスト説明',
            'price' => 1000,
            'condition_id' => $condition->id,
            'categories' => [$category->id],
            'image' => UploadedFile::fake()->create('test.jpg', 100, 'image/jpeg'),
        ]);

        $this->assertDatabaseHas('items', [
            'name' => 'テスト商品',
            'brand_name' => 'テストブランド',
            'description' => 'テスト説明',
            'price' => 1000,
            'user_id' => $user->id,
        ]);
    }
}
