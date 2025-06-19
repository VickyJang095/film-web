<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function store(Request $request, Movie $movie)
    {
        $request->validate([
            'episode_number' => 'required|integer|min:1',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'video' => 'required|file|mimes:mp4,webm|max:512000',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,webp|max:5120',
            'duration' => 'nullable|integer|min:0',
            'status' => 'nullable|in:draft,published',
        ]);

        // Kiểm tra và xóa tập phim cũ nếu có cùng số tập
        $oldEpisode = $movie->episodes()->where('episode_number', $request->episode_number)->first();
        if ($oldEpisode) {
            // Xóa file video cũ
            if ($oldEpisode->video_path && Storage::disk('public')->exists($oldEpisode->video_path)) {
                Storage::disk('public')->delete($oldEpisode->video_path);
            }
            // Xóa file thumbnail cũ
            if ($oldEpisode->thumbnail_path && Storage::disk('public')->exists($oldEpisode->thumbnail_path)) {
                Storage::disk('public')->delete($oldEpisode->thumbnail_path);
            }
            // Xóa record trong DB
            $oldEpisode->delete();
        }

        $videoPath = $request->file('video')->store('episodes', 'public');
        $thumbnailPath = $request->hasFile('thumbnail') ? $request->file('thumbnail')->store('episode_thumbnails', 'public') : null;

        $movie->episodes()->create([
            'episode_number' => $request->episode_number,
            'title' => $request->title,
            'description' => $request->description,
            'video_path' => $videoPath,
            'thumbnail_path' => $thumbnailPath,
            'duration' => $request->duration ?? 0,
            'status' => $request->status ?? 'published',
        ]);

        return redirect()->route('movies.show', $movie)->with('success', 'Đã thêm tập mới!');
    }

    /**
     * Xóa tập phim
     */
    public function destroy(Movie $movie, Episode $episode)
    {
        // Kiểm tra xem tập phim có thuộc về phim này không
        if ($episode->movie_id !== $movie->id) {
            abort(404);
        }

        // Xóa file video nếu có
        if ($episode->video_path && Storage::disk('public')->exists($episode->video_path)) {
            Storage::disk('public')->delete($episode->video_path);
        }

        // Xóa file thumbnail nếu có
        if ($episode->thumbnail_path && Storage::disk('public')->exists($episode->thumbnail_path)) {
            Storage::disk('public')->delete($episode->thumbnail_path);
        }

        // Xóa record trong DB
        $episode->delete();

        return redirect()->back()->with('success', 'Đã xóa tập phim thành công.');
    }
} 