<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Episode;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::with('categories')->latest()->paginate(12);
        return view('movies.index', compact('movies'));
    }

    public function show(Movie $movie)
    {
        $movie->load(['categories', 'comments.user']);
        $relatedMovies = Movie::whereHas('categories', function($q) use ($movie) {
            return $q->whereIn('categories.id', $movie->categories->pluck('id'));
        })
        ->where('id', '!=', $movie->id)
        ->latest()
        ->take(12)
        ->get();        
        return view('movies.show', compact('movie', 'relatedMovies'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('movies.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'release_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'duration' => 'required|integer|min:1',
            'poster' => 'nullable|image|max:2048',
            'video' => 'nullable|file|mimes:mp4|max:102400',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id'
        ]);

        if ($request->hasFile('poster')) {
            $validated['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        if ($request->hasFile('video')) {
            $validated['video_path'] = $request->file('video')->store('videos', 'public');
        }

        $movie = Movie::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'release_year' => $validated['release_year'],
            'duration' => $validated['duration'],
            'poster_path' => $validated['poster_path'] ?? null,
            'video_path' => $validated['video_path'] ?? null,
            'status' => 'published'
        ]);

        $movie->categories()->attach($validated['categories']);

        return redirect()->route('movies.show', $movie)
            ->with('success', 'Phim đã được thêm thành công.');
    }

    public function edit(Movie $movie)
    {
        $categories = Category::all();
        return view('movies.edit', compact('movie', 'categories'));
    }

    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'release_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'duration' => 'required|integer|min:1',
            'poster' => 'nullable|image|max:2048',
            'video' => 'nullable|file|mimes:mp4|max:102400',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id'
        ]);

        if ($request->hasFile('poster')) {
            if ($movie->poster_path) {
                Storage::disk('public')->delete($movie->poster_path);
            }
            $validated['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        if ($request->hasFile('video')) {
            if ($movie->video_path) {
                Storage::disk('public')->delete($movie->video_path);
            }
            $validated['video_path'] = $request->file('video')->store('videos', 'public');
        }

        $movie->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'release_year' => $validated['release_year'],
            'duration' => $validated['duration'],
            'poster_path' => $validated['poster_path'] ?? $movie->poster_path,
            'video_path' => $validated['video_path'] ?? $movie->video_path
        ]);

        $movie->categories()->sync($validated['categories']);

        if ($request->hasFile('episode_files')) {
            foreach ($request->file('episode_files') as $index => $file) {
                if ($file && isset($request->episode_titles[$index])) {
                    $episodePath = $file->store('episodes', 'public');
                    $episodeTitle = $request->episode_titles[$index];
        
                    // Lưu tập phim vào DB
                    Episode::create([
                        'movie_id' => $movie->id,
                        'title' => $episodeTitle,
                        'video_path' => $episodePath,
                    ]);
                }
            }
        }

        return redirect()->route('movies.show', $movie)
            ->with('success', 'Phim đã được cập nhật thành công.');
    }

    public function destroy(Movie $movie)
    {
        if ($movie->poster_path) {
            Storage::disk('public')->delete($movie->poster_path);
        }
        if ($movie->video_path) {
            Storage::disk('public')->delete($movie->video_path);
        }

        $movie->delete();

        return redirect()->route('movies.index')
            ->with('success', 'Phim đã được xóa thành công.');
    }
}
