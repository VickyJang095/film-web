<?php

namespace App\Repositories;

use App\Interfaces\MovieRepositoryInterface;
use App\Models\Movie;
use Illuminate\Support\Facades\Storage;

class MovieRepository implements MovieRepositoryInterface
{
    public function getAllMovies()
    {
        return Movie::all();
    }

    public function getMovieById($id)
    {
        return Movie::findOrFail($id);
    }

    public function createMovie(array $data)
    {
        return Movie::create($data);
    }

    public function updateMovie($id, array $data)
    {
        $movie = Movie::findOrFail($id);
        $movie->update($data);
        return $movie;
    }

    public function deleteMovie($id)
    {
        return Movie::destroy($id);
    }

    public function index()
    {
        return Movie::with('categories')->latest()->paginate(12);
    }

    public function store(array $data)
    {
        if (isset($data['poster'])) {
            $data['poster_path'] = $data['poster']->store('posters', 'public');
        }
        if (isset($data['video'])) {
            $data['video_path'] = $data['video']->store('videos', 'public');
        }
        
        $movie = Movie::create($data);
        if (isset($data['categories'])) {
            $movie->categories()->attach($data['categories']);
        }
        return $movie;
    }

    public function getById($id)
    {
        return Movie::with(['categories', 'comments.user'])->findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $movie = Movie::findOrFail($id);
        
        if (isset($data['poster'])) {
            if ($movie->poster_path) {
                Storage::disk('public')->delete($movie->poster_path);
            }
            $data['poster_path'] = $data['poster']->store('posters', 'public');
        }
        
        if (isset($data['video'])) {
            if ($movie->video_path) {
                Storage::disk('public')->delete($movie->video_path);
            }
            $data['video_path'] = $data['video']->store('videos', 'public');
        }
        
        $movie->update($data);
        if (isset($data['categories'])) {
            $movie->categories()->sync($data['categories']);
        }
        
        return $movie;
    }

    public function delete($id)
    {
        $movie = Movie::findOrFail($id);
        if ($movie->poster_path) {
            Storage::disk('public')->delete($movie->poster_path);
        }
        if ($movie->video_path) {
            Storage::disk('public')->delete($movie->video_path);
        }
        return $movie->delete();
    }
}
