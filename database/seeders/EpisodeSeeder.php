<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;
use App\Models\Episode;

class EpisodeSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy tất cả phim bộ
        $seriesMovies = Movie::where('type', 'series')->get();

        foreach ($seriesMovies as $movie) {
            // Tạo 10 tập phim cho mỗi phim bộ
            for ($i = 1; $i <= 10; $i++) {
                Episode::create([
                    'movie_id' => $movie->id,
                    'title' => "Tập {$i}",
                    'episode_number' => $i,
                    'description' => "Mô tả tập {$i} của phim {$movie->title}",
                    'video_path' => 'videos/sample.mp4', // Đường dẫn video mẫu
                    'thumbnail_path' => $movie->poster_path, // Sử dụng poster của phim làm thumbnail
                    'duration' => rand(40, 60), // Thời lượng ngẫu nhiên từ 40-60 phút
                    'status' => 'published'
                ]);
            }
        }
    }
} 