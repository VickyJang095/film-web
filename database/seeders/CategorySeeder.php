<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Phim truyền hình',
                'slug' => Str::slug('Phim truyền hình'),
                'description' => 'Các bộ phim truyền hình dài tập'
            ],
            [
                'name' => 'Hành động',
                'slug' => Str::slug('Hành động'),
                'description' => 'Phim hành động, phiêu lưu, mạo hiểm'
            ],
            [
                'name' => 'Kinh dị',
                'slug' => Str::slug('Kinh dị'),
                'description' => 'Phim kinh dị, ma, quỷ'
            ],
            [
                'name' => 'Phiêu lưu',
                'slug' => Str::slug('Phiêu lưu'),
                'description' => 'Phim phiêu lưu, khám phá'
            ],
            [
                'name' => 'Tình cảm',
                'slug' => Str::slug('Tình cảm'),
                'description' => 'Phim tình cảm, lãng mạn'
            ],
            [
                'name' => 'Bí ẩn',
                'slug' => Str::slug('Bí ẩn'),
                'description' => 'Phim bí ẩn, trinh thám'
            ],
            [
                'name' => 'Lịch sử',
                'slug' => Str::slug('Lịch sử'),
                'description' => 'Phim lịch sử, cổ trang'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
} 