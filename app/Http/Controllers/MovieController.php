<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Category;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Episode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\UpdateMovieRequest;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::with('categories')->latest()->paginate(12);
        return view('movies.index', compact('movies'));
    }

    public function show(Movie $movie)
    {
        // Tăng lượt xem mỗi lần vào trang chi tiết
        $movie->increment('views');

        $movie->load(['categories', 'comments.user', 'country', 'episodeList']);
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
        $countries = Country::all();    
        return view('movies.create', compact('categories', 'countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'release_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'duration' => 'required|integer|min:1',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'video' => 'nullable|file|mimes:mp4|max:102400',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id',
            'country_id' => 'required|exists:countries,id',
            'type' => 'required|in:single,series',
            'episode_count' => 'required_if:type,series|nullable|integer|min:1',
        ]);

        if ($request->hasFile('poster')) {
            $validated['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        if ($request->hasFile('video')) {
            $validated['video_path'] = $request->file('video')->store('videos', 'public');
        }

        $movie = Movie::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'description' => $validated['description'],
            'release_year' => $validated['release_year'],
            'duration' => $validated['duration'],
            'poster_path' => $validated['poster_path'] ?? null,
            'video_path' => $validated['video_path'] ?? null,
            'country_id' => $validated['country_id'],
            'status' => 'published'
        ]);

        // Gán thể loại
        $movie->categories()->attach($validated['category_ids']);

        return redirect()->route('movies.show', $movie)
            ->with('success', 'Phim đã được thêm thành công.');
    }

    public function edit(Movie $movie)
    {
        $categories = Category::all();
        $countries = Country::all();
        return view('movies.edit', compact('movie', 'categories', 'countries'));
    }

    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        Log::info('Update movie request data:', $request->all());
        
        $data = $request->validated();
        Log::info('Validated data:', $data);
        Log::info('Current movie type:', ['type' => $movie->type]);
        Log::info('New type value:', ['type' => $data['type']]);
        
        // Xử lý poster
        if ($request->hasFile('poster')) {
            if ($movie->poster_path) {
                Storage::disk('public')->delete($movie->poster_path);
            }
            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        } elseif ($request->input('remove_poster') === '1') {
            if ($movie->poster_path) {
                Storage::disk('public')->delete($movie->poster_path);
            }
            $data['poster_path'] = null;
        }

        // Cập nhật slug nếu title thay đổi
        if ($movie->title !== $data['title']) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Cập nhật thông tin phim
        $movie->update($data);
        Log::info('Movie updated:', $movie->toArray());

        // Cập nhật thể loại
        if (isset($data['categories'])) {
            $movie->categories()->sync($data['categories']);
            Log::info('Categories synced:', $data['categories']);
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
    public function latest()
    {
        $movies = Movie::orderBy('created_at', 'desc')->take(12)->get(); // lấy 12 phim mới nhất
        return view('movies.latest', compact('movies'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $movies = Movie::where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->paginate(12);
        return view('movies.search', compact('movies', 'query'));
    }
    public function rate(Request $request, Movie $movie)
    {
        $request->validate([
            'rating' => 'required|numeric|min:1|max:10'
        ]);

        $movie->rating = ($movie->rating * $movie->rating_count + $request->rating) / ($movie->rating_count + 1);
        $movie->rating_count++;
        $movie->save();

        return back()->with('success', 'Đánh giá của bạn đã được ghi nhận.');
    }


}
