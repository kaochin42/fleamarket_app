<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ProfileEditTest extends TestCase
{
    use RefreshDatabase;

    // 変更項目が初期値として過去設定されていること
    public function test_profile_edit_has_initial_values()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'postcode' => '123-4567',
            'address' => 'テスト住所',
        ]);

        $response = $this->actingAs($user)->get('/mypage/profile');

        $response->assertSee('テストユーザー');
        $response->assertSee('123-4567');
        $response->assertSee('テスト住所');
    }
}
