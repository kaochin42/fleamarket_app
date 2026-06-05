<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => '山田太郎',
                'email' => 'test@test.com',
                'password' => bcrypt('password'),
                'postcode' => '123-4567',
                'address' => '大坂府大坂市なにわ区',
                'email_verified_at' => now(),
                'profile_img' => 'profiles/くま.png',
            ],
            [
                'name' => 'さとう',
                'email' => 'user@test.com',
                'password' => bcrypt('password'),
                'postcode' => '890-1234',
                'address' => '東京都天王寺市あびこ3丁目',
                'email_verified_at' => now(),
                'profile_img' => 'profiles/うさぎ.png',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
