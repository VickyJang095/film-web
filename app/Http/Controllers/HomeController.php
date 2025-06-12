<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy phim mới nhất có rating cao nhất
        $featuredMovie = Movie::orderBy('rating', 'desc')
            ->orderBy('created_at', 'desc')
            ->first();

        // Lấy danh sách phim mới nhất
        $latestMovies = Movie::orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        // Lấy danh sách phim có rating cao nhất
        $trendingMovies = Movie::orderBy('rating', 'desc')
            ->take(8)
            ->get();

        return view('welcome', compact('featuredMovie', 'latestMovies', 'trendingMovies'));
    }
} 