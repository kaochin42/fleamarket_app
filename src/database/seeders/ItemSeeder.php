<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'user_id' => 1,
                'condition_id' => 1,
                'name' => '腕時計',
                'brand_name' => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'image_path' => 'items/Armani+Mens+Clock.jpg',
                'price' => '15000',
                'categories' => [ 1, 3],
            ],
            [
                'user_id' => 1,
                'condition_id' => 2,
                'name' => 'HDD',
                'brand_name' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'image_path' => 'items/HDD+Hard+Disk.jpg',
                'price' => '5000',
                'categories' => [2],
            ],
            [
                'user_id' => 1,
                'condition_id' => 3,
                'name' => '玉ねぎ3束',
                'brand_name' => 'なし',
                'description' => '新鮮な玉ねぎ３束のセット',
                'image_path' => 'items/iLoveIMG+d.jpg',
                'price' => '300',
                'categories' => [10],
            ],
            [
                'user_id' => 1,
                'condition_id' => 4,
                'name' => '革靴',
                'description' => 'クラシックなデザインの革靴',
                'image_path' => 'items/Leather+Shoes+Product+Photo.jpg',
                'price' => '4000',
                'categories' => [1, 5, 12],
            ],
            [
                'user_id' => 1,
                'condition_id' => 1,
                'name' => 'ノートPC',
                'description' => '高性能なノートパソコン',
                'image_path' => 'items/Living+Room+Laptop.jpg',
                'price' => '45000',
                'categories' => [2],
            ],
            [
                'user_id' => 2,
                'condition_id' => 2,
                'name' => 'マイク',
                'brand_name' => 'なし',
                'description' => '高音質のレコーディング用マイク',
                'image_path' => 'items/Music+Mic+4632231.jpg',
                'price' => '8000',
                'categories' => [13],
            ],
            [
                'user_id' => 2,
                'condition_id' => 3,
                'name' => 'ショルダーバッグ',
                'description' => 'おしゃれなショルダーバッグ',
                'image_path' => 'items/Purse+fashion+pocket.jpg',
                'price' => '3500',
                'categories' => [1, 11],
            ],
            [
                'user_id' => 2,
                'condition_id' => 4,
                'name' => 'タンブラー',
                'brand_name' => 'なし',
                'description' => '使いやすいタンブラー',
                'image_path' => 'items/Tumbler+souvenir.jpg',
                'price' => '500',
                'categories' => [10],
            ],
            [
                'user_id' => 2,
                'condition_id' => 1,
                'name' => 'コーヒーミル',
                'brand_name' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'image_path' => 'items/Waitress+with+Coffee+Grinder.jpg',
                'price' => '4000',
                'categories' => [2, 10],
            ],
            [
                'user_id' => 2,
                'condition_id' => 2,
                'name' => 'メイクセット',
                'description' => '便利なメイクアップセット',
                'image_path' => 'items/外出メイクアップセット.jpg',
                'price' => '2500',
                'categories' => [4, 6, 14],
            ],
        ];

        foreach ($items as $item) {
            $categories = $item['categories'];
            unset($item['categories']);

            $created = Item::create($item);

            foreach ($categories as $categoryId) {
                DB::table('item_category')->insert([
                    'item_id' => $created->id,
                    'category_id' => $categoryId,
                ]);
            }
        }
    }
}