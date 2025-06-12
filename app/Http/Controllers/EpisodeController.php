<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Episode;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    /**
     * Hiển thị trang xem tập phim
     */
    public function show(Movie $movie, Episode $episode)
    {
        // Kiểm tra xem tập phim có thuộc về phim này không
        if ($episode->movie_id !== $movie->id) {
            abort(404);
        }

        // Lấy danh sách các tập phim khác của bộ phim này
        $otherEpisodes = $movie->episodes()
            ->where('id', '!=', $episode->id)
            ->orderBy('episode_number')
            ->get();

        return view('episodes.show', compact('movie', 'episode', 'otherEpisodes'));
    }
} 