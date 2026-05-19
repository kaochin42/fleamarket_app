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
                'postcode' => '1234567',
                'address' => '大坂府大坂市なにわ区',
            ],
            [
                'name' => 'さとう',
                'email' => 'user@test.com',
                'password' => bcrypt('password'),
                'postcode' => '8901234',
                'address' => '東京都天王寺市あびこ3丁目',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
