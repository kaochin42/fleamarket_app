<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Database\Seeders\ConditionSeeder;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ConditionSeeder::class);
    }

    // 1. ログイン済みユーザーはコメントを送信できる
    public function test_logged_in_user_can_comment()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post('/item/' . $item->id . '/comment', [
            'comment' => 'テストコメント',
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'テストコメント',
        ]);
    }

    // 2. ログイン前のユーザーはコメントを送信できない
    public function test_guest_cannot_comment()
    {
        $item = Item::factory()->create();

        $response = $this->post('/item/' . $item->id . '/comment', [
            'comment' => 'テストコメント',
        ]);

        $this->assertDatabaseMissing('comments', [
            'comment' => 'テストコメント',
        ]);
    }

    // 3. コメントが入力されていない場合バリデーションメッセージが表示される
    public function test_comment_is_required()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post('/item/' . $item->id . '/comment', [
            'comment' => '',
        ]);

        $response->assertSessionHasErrors(['comment']);
    }

    // 4. コメントが255文字以上の場合バリデーションメッセージが表示される
    public function test_comment_max_length()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post('/item/' . $item->id . '/comment', [
            'comment' => str_repeat('あ', 256),
        ]);

        $response->assertSessionHasErrors(['comment']);
    }
}
