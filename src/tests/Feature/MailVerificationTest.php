<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

class MailVerificationTest extends TestCase
{
    use RefreshDatabase;

    // 1. 会員登録後、認証メールが送信される
    public function test_verification_email_is_sent_after_register()
    {
        Event::fake();

        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        Event::assertDispatched(Registered::class);
    }

    // 2. 「認証はこちらから」ボタンを押下するとメール認証サイトに遷移する
    public function test_verification_link_redirects_to_verify()
    {
        $user = User::factory()->create(['email_verified_at' => null]);

        $response = $this->actingAs($user)->get('/email/verify');

        $response->assertStatus(200);
    }

    // 3. メール認証を完了するとプロフィール設定画面に遷移する
    public function test_verified_user_is_redirected_to_profile()
    {
        $user = User::factory()->create(['email_verified_at' => null]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertRedirect('/mypage/profile?verified=1');
    }
}
